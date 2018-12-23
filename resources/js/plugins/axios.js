import axios from 'axios'
import store from '~/store'
import router from '~/router'
import swal from 'sweetalert2'
import Types from '../store/types'

// Request interceptor
axios.interceptors.request.use((request) => {
  const token = store.getters['token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
    request.headers.common['Content-Type'] = `application/json`
    request.headers.common['Accept'] = `application/json`
  }
  return request
})

// Response interceptor
axios.interceptors.response.use(
  (response) => response,
  (error) => {
    const {
      status
    } = error.response

    if (status >= 500) {
      swal({
        type: 'error',
        title: 'Error',
        text: 'Something Went Wrong',
        reverseButtons: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel'
      })
    }

    if (status === 401 && store.getters['check']) {
      swal({
        type: 'warning',
        title: 'Token Expired',
        text: 'Your Token Expired',
        reverseButtons: true,
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel'
      }).then(() => {
        store.commit(Types.mutations.LOGOUT)
        router.push({
          name: 'login'
        })
      })
    }
    return Promise.reject(error)
  }
)

const GET = (url, params = {}, failure = null) => {
  return axios
    .get(url, {
      params
    })
    .catch(
      failure ||
      ((error) => {
        let {
          response: {
            data: {
              error: {
                message: errorMessage
              }
            }
          }
        } = error
        console.log(errorMessage)
      })
    )
}

const POST = (url, params = {}, failure = null) => {
  return axios.post(url, params).catch(
    failure ||
    ((error) => {
      let {
        response: {
          data: {
            error: {
              message: errorMessage
            }
          }
        }
      } = error
      console.log(errorMessage)
    })
  )
}

const PUT = (url, params = {}, failure = null) => {
  return axios.put(url, params).catch(
    failure ||
    ((error) => {
      // console.log('Request.js PUT', error.response)
      let {
        response: {
          data: {
            error: {
              message: errorMessage
            }
          }
        }
      } = error
      console.log(errorMessage)
    })
  )
}

const PATCH = (url, params = {}, failure = null) => {
  return axios.patch(url, params).catch(
    failure ||
    ((error) => {
      // console.log('Request.js PUT', error.response)
      let {
        response: {
          data: {
            error: {
              message: errorMessage
            }
          }
        }
      } = error
      console.log(errorMessage)
    })
  )
}

const DELETE = (url, params = {}, failure = null) => {
  return axios.delete(url, params).catch(
    failure ||
    ((error) => {
      // console.log('Request.js DELETE', error.response)
      let {
        response: {
          data: {
            error: {
              message: errorMessage
            }
          }
        }
      } = error
      console.log(errorMessage)
    })
  )
}

export {
  GET,
  POST,
  PUT,
  DELETE,
  PATCH
}
