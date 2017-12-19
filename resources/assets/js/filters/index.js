import moment from 'moment'

// Dates
export function fromNow (value) {
  return moment.utc(value).local().fromNow()
}

export function fromUTC (value, format = 'MMMM Do YYYY') {
  return moment.utc(value).local().format(format)
}

export function dateFormat (value, format = 'MMMM Do YYYY') {
  return moment(value).format(format)
}
