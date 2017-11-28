/*
 <a href="posts/2" data-method="delete"> <---- We want to send an HTTP DELETE request

 - Or, request confirmation in the process -

 <a href="posts/2" data-method="delete" data-confirm="Are you sure?">
 */

(function() {

  var areyousure = {
    initialize: function() {
      this.registerEvents()
    },

    registerEvents: function() {
      $('body').on('click', 'a[data-method]', this.handleMethod)
    },

    handleMethod: function(e) {
      var link = $(this)
      var httpMethod = link.data('method').toUpperCase()
      var form

      // If the data-method attribute is not PUT or DELETE,
      // then we don't know what to do. Just ignore.
      if ( $.inArray(httpMethod, ['PUT', 'DELETE']) === - 1 ) {
        return
      }

      // Allow user to optionally provide data-confirm="Are you sure?"
      areyousure.verifyConfirm(link)
        .then(answer => {
          if (answer) {
            form = areyousure.createForm(link)
            form.submit()
          }
        })

      e.preventDefault()
    },

    verifyConfirm: function(link) {
      return swal({
        title: "Are you sure?",
        text: "You will not be able to undo this!",
        icon: "warning",
        buttons: ['Cancel', 'Delete']
      })
    },

    createForm: function(link) {
      var form =
        $('<form>', {
          'method': 'POST',
          'action': link.attr('href')
        })

      var token =
        $('<input>', {
          'name': '_token',
          'type': 'hidden',
          'value': window.app.csrfToken
        })

      var hiddenInput =
        $('<input>', {
          'name': '_method',
          'type': 'hidden',
          'value': link.data('method')
        })

      return form.append(token, hiddenInput)
        .appendTo('body')
    }
  }

  areyousure.initialize()

})()
