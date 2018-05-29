import Axios from 'axios'

export default {
  get (relativePath, callback, params) {
    Axios.get(relativePath, {params: params})
      .then(response => {
        callback(response.data.data)
      }).catch(error => {
      
    })
  }
}