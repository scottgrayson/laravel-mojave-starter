<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SEO;

class CrudController extends Controller
{
    protected $model;
    protected $slug;
    protected $table;
    protected $singular;
    protected $fields;
    protected $formRequest;
    protected $cols;
    protected $relations;
    protected $orderable;

    public function __construct()
    {
        $this->table = $this->table ?: str_replace('-', '_', $this->slug);
        $this->slug = $this->slug ?: str_slug($this->table);
        $this->singular = $this->singular ?: str_singular($this->slug);
        $this->plural = isset($this->plural) ? $this->plural : $this->slug;

        // crud index columns
        $dbCols = collect(\Schema::getColumnListing($this->table));

        // global index page table excludes
        $this->cols = $dbCols->filter(
            function ($c) {
                return !in_array(
                    $c,
                    [
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

        $this->relations = collect(preg_replace('/_id$/', '', preg_grep('/_id$/', $this->cols)))
            ->map(
                function ($c) {
                    return camel_case($c);
                }
            )->toArray();

        // crud form fields
        if (!$this->fields && $this->formRequest) {
            $this->fields = $this->getFieldsFromRules(new $this->formRequest);
        } else {
            $this->fields = collect($dbCols)
                ->filter(
                    function ($c) {
                        return !in_array(
                            $c,
                            [
                            'file',
                            'description',
                            'remember_token',
                            'password',
                            'created_at',
                            'updated_at'
                            ]
                        );
                    }
                )
                // change to validation rules format
                ->mapWithKeys(
                    function ($c) {
                        return [$c => ['nullable']];
                    }
                );
        }
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

        $relations = $this->relations;
        $cols = $this->cols;
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

        return view(
            'admin.crud.index',
            [
            'cols' => $this->cols,
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

        return view(
            'admin.crud.create',
            [
            'slug' => $this->slug,
            'model' => $this->model,
            'fields' => $this->fields,
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

        $data = array_intersect_key($data, $this->fields->toArray());

        $item = $this->model::create($data);

        flash($this->singular . ' created.');

        return redirect(route("admin.$this->slug.edit", $item->id));
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

        return view(
            'admin.crud.show',
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

        return view(
            'admin.crud.edit',
            [
            'item' => $item,
            'model' => $this->model,
            'slug' => $this->slug,
            'fields' => $this->fields,
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

        $data = array_intersect_key($data, $this->fields->toArray());

        $item->update($data);

        flash($this->singular . ' updated.');

        return redirect(route("admin.$this->slug.edit", $item->id));
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

        return redirect(route("admin.$this->slug.index"));
    }


    public function order()
    {
        SEO::setTitle('Order ' . title_case($this->plural));
        SEO::setDescription('Order ' . title_case($this->plural));

        return view('admin.crud.order', [
            'items' => $this->model::getTree(),
            'slug' => $this->slug,
        ]);
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
