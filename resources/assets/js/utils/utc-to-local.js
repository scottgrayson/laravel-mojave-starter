$().ready(function() {
  $('.utc-to-local').each(function() {
    const format = $(this).attr('format')
    const utcDate = $(this).text()
    let formatted = ''

    let local = moment.utc(utcDate).local()

    if (format === 'fromNow') {
      formatted = local.fromNow()
    } else if (format) {
      formatted = local.format(format)
    } else {
      formatted = local.format('LLL')
    }

    $(this).text(formatted)
    $(this).show()
  })
})
