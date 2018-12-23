const apipath = '/api/'

export const AUTH_CHECK = apipath + 'auth-check'
export const LOGIN = apipath + 'login'
export const REGISTER = apipath + 'register'
export const SEND_PASSWORD_RESET_EMAIL = apipath + 'password/email'
export const PASSWORD_RESET = apipath + 'password/reset'
export const CHANGE_PASSWORD = apipath + 'settings/password'
export const UPDATE_PROFILE = apipath + 'settings/profile'
export const USER_PHOTO_UPLOAD = apipath + 'settings/profile'
export const FETCH_USER = apipath + 'user'
export const LOGOUT = apipath + 'logout'

export const EMPLOYEES = apipath + 'users?include=userInfo.position'
export const EMPLOYEE_CREATE = apipath + 'user-create'
export const USER_DROPDOWN = apipath + 'users/dropdown'

export const ROLE_DRODOWN = apipath + 'roles-dropdown'
export const POSITION_DRODOWN = apipath + 'position/dropdown'

export const HOLIDAYS = apipath + 'holidays-by-month'

export const ATTENDANCE_CREATE = apipath + 'attendance-create'
export const TODAY_ATTENDANCE_FOR_SPECIFIC_USER = apipath + 'attendance-today-for-user'
export const USER_CURRENT_MONTH_ATTENDANCE_STATTISTICS = apipath + 'attendance-current-month-statistics-for-user'

export const CALENDAR_ATTENDANCE_BY_MONTH = apipath + 'attendances-by-month/calendar'
export const CALENDAR_ATTENDANCE_BY_DATE = apipath + 'attendances-by-date/calendar?include=user'

export const USER_ATTENDANCE_STATISTICS_TODAY = apipath + 'attendance/user/statistics'
export const USER_ATTENDANCE_STATISTICS_TODAY_PERCENTAGE = apipath + 'attendance/user/statistics/percentage'

export const USER_CURRENT_SALARY = apipath + 'users?include=userInfo.position,baseSalaries'
export const USER_NEW_SALARY = apipath + 'base-salary'

export const GET_ALL_POSITIONS = apipath + 'positions'
