import QS from 'query-string'

export default class Query {
  /**
   * Create a new Form instance.
   *
   * @param {object} data
   */
  constructor (obj) {
    this.originalData = obj

    for (const field in obj) {
      this[field] = obj[field]
    }
  }

  /**
   * Fetch all relevant data for the form.
   */
  toString () {
    var qObj = {}

    for (const key in this.originalData) {
      if (this[key]) {
        qObj[key] = this[key]
      }
    }

    return QS.stringify(qObj, { arrayFormat: 'bracket' })
  }

  parse (str) {
    var qObj = QS.parse(str, { arrayFormat: 'bracket' })
    for (const key in this.originalData) {
      if (typeof this.originalData[key] === 'object') {
        if (qObj[key]) {
          this[key] = this.originalData[key].concat(qObj[key])
        }
      } else {
        this[key] = qObj[key] || this.originalData[key]
      }
    }
  }

  replace () {
    history.replaceState(null, null, window.location.pathname + '?' + this.toString())
  }

  push () {
    history.pushState(null, null, window.location.pathname + '?' + this.toString())
  }

  /**
   * Reset the form fields.
   */
  reset () {
    for (const field in this.originalData) {
      this[field] = this.originalData[field]
    }
  }
}
