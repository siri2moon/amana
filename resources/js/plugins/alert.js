import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'

let options = {
  position: 'top-end',
  showConfirmButton: false,
  timer: 2000,
}

let success = msg => {
  return Swal.mixin(options).fire(msg, 'Success', 'success')
}

let error = msg => {
  return Swal.mixin(options).fire(msg, 'Error', 'error')
}

let notification = () => {
  return Swal.mixin(options)
}

export {success, error, notification}
