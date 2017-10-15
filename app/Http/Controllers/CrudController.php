<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SEO;

class CrudController extends Controller
{
    protected $model;
    protected $slug;
    protected $table;
    protected $singular;
    protected $formRequest;
    protected $orderable;
    protected $columns;

    public function __construct()
    {
        $this->table = $this->table ?: str_replace('-', '_', $this->slug);
        $this->slug = $this->slug ?: str_slug($this->table);
        $this->singular = $this->singular ?: str_singular($this->slug);
        $this->plural = isset($this->plural) ? $this->plural : $this->slug;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO if where.like sorts by relevance, dont have a default sort
        $defaultSort = isset($this->defaultSort) ? $this->defaultSort : 'created_at';
        $defaultOrder = isset($this->defaultOrder) ? $this->defaultOrder : 'desc';

        if ($this->columns) {
            $cols = $this->columns;
        } else {
            // crud index columns
            $dbCols = collect(\Schema::getColumnListing($this->table));

            // global index page table excludes
            $cols = $dbCols->filter(
                function ($c) {
                    return !in_array(
                        $c, [
                            'layout',
                            'content',
                            'meta_title',
                            'meta_description',
                            'meta_tags',
                            'order',
                            'path',
                            'bucket',
                            'message',
                            'file',
                            'description',
                            'remember_token',
                            'password'
                        ]
                    );
                }
            )->toArray();
        }

        $relations = collect(preg_replace('/_id$/', '', preg_grep('/_id$/', $cols)))
            ->map(
                function ($c) {
                    return camel_case($c);
                }
            )->toArray();

        $items = $this->model::with($relations)
            ->where(
                function ($q) use ($request, $relations, $cols) {
                    $wheres = collect($request->query())
                        ->filter(
                            function ($v, $k) {
                                return $v && strpos($k, 'q_') === 0;
                            }
                        )
                        ->mapWithKeys(
                            function ($v, $k) {
                                return [ str_replace('q_', '', $k) => $v ];
                            }
                        );
                    foreach ($wheres as $k => $v) {
                        if (in_array(camel_case($k), $relations)) {
                            $class = '\\App\\'.studly_case($k);
                            $q->whereHas(
                                camel_case($k),
                                function ($q) use ($class, $v) {
                                    $q->where($class::label(), 'ilike', $v.'%');
                                }
                            );
                        } else {
                            if (in_array($k, $cols)) {
                                // check to make sure it is a col to avoid injection
                                $q->whereRaw("cast ({$k} as varchar) ilike ?", [$v.'%']);
                            }
                        }
                    }
                }
            )
            ->orderBy(
                request('sort', $defaultSort),
                request('order', $defaultOrder)
            )
            ->paginate(config('settings.paginate'));

        SEO::setTitle(title_case($this->plural));
        SEO::setDescription('View ' . title_case($this->plural));

        // Include the request variables in the pagination links
        $items->appends(request()->all());

        $viewPrefix = request()->is('admin*') ? 'admin.' : '';

        return view(
            $viewPrefix.'crud.index',
            [
                'cols' => $cols,
                'slug' => $this->slug,
                'model' => $this->model,
                'orderable' => $this->orderable,
                'items' => $items,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        SEO::setTitle('Create ' . title_case($this->singular));
        SEO::setDescription('Create ' . title_case($this->singular));

        $fields = $this->getFieldsFromRules(new $this->formRequest);

        $viewPrefix = request()->is('admin*') ? 'admin.' : '';

        return view(
            $viewPrefix.'crud.create',
            [
                'slug' => $this->slug,
                'model' => $this->model,
                'fields' => $fields,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // manually invoke form request
        if ($this->formRequest) {
            app($this->formRequest);
        }

        $data = $this->handleFileUploads();

        $fields = $this->getFieldsFromRules(new $this->formRequest);

        $data = array_intersect_key($data, $fields->toArray());

        $item = $this->model::create($data);

        flash($this->singular . ' created.');

        if (request()->is('admin*')) {
            return redirect(route("admin.$this->slug.edit", $item->id));
        }
        return redirect(route("$this->slug.edit", $item->id));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = $this->model::findOrFail($id);

        SEO::setTitle(title_case($this->singular) . ': ' . $item->label);
        SEO::setDescription('View ' . title_case($this->singular) . ': ' . $item->label);

        $viewPrefix = request()->is('admin*') ? 'admin.' : '';

        return view(
            $viewPrefix.'crud.show',
            [
                'item' => $item,
                'model' => $this->model,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->model::findOrFail($id);

        SEO::setTitle('Edit ' . title_case($this->singular) . ': ' . $item->label);
        SEO::setDescription('Edit ' . title_case($this->singular) . ': ' . $item->label);

        $fields = $this->getFieldsFromRules(new $this->formRequest);

        $viewPrefix = request()->is('admin*') ? 'admin.' : '';

        return view(
            $viewPrefix.'crud.edit',
            [
                'item' => $item,
                'model' => $this->model,
                'slug' => $this->slug,
                'fields' => $fields,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = $this->model::findOrFail($id);

        // manually invoke form request
        if ($this->formRequest) {
            app($this->formRequest);
        }

        $data = $this->handleFileUploads();

        $fields = $this->getFieldsFromRules(new $this->formRequest);

        $data = array_intersect_key($data, $fields->toArray());

        $item->update($data);

        flash($this->singular . ' updated.');

        if (request()->is('admin*')) {
            return redirect(route("admin.$this->slug.edit", $item->id));
        }
        return redirect(route("$this->slug.edit", $item->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->model::findOrFail($id);
        $item->delete();

        flash($this->singular . ' deleted.');

        if (request()->is('admin*')) {
            return redirect(route("admin.$this->slug.index"));
        }
        return redirect(route("$this->slug.index"));
    }


    public function order()
    {
        SEO::setTitle('Order ' . title_case($this->plural));
        SEO::setDescription('Order ' . title_case($this->plural));

        $viewPrefix = request()->is('admin*') ? 'admin.' : '';

        return view(
            $viewPrefix.'crud.order',
            [
                'items' => $this->model::getTree(),
                'slug' => $this->slug,
            ]
        );
    }

    public function reorder(Request $request)
    {
        if (!request('order')) {
            flash("Error while updating $this->singular order.");
            return redirect(route("admin.$this->slug.order"));
        }

        $orderArray = explode(',', request('order'));

        $order = array_flip($orderArray);

        // TODO would be more efficient to do delete than reinsert
        // but is that safe? Would users load a page with 0 menu items

        foreach ($this->model::all() as $i) {
            if (isset($order[$i->id])) {
                $i->update(['order' => $order[$i->id]]);
            } else {
                flash("Error while updating $this->singular order.");
                return redirect(route("admin.$this->slug.order"));
            }
        };

        flash("$this->singular order updated.");

        return redirect(route("admin.$this->slug.order"));
    }
}
