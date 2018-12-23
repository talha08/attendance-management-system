// frontend
const Navbar = () => import('~/components/Navbar').then(m => m.default || m)
const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () =>
  import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () =>
  import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)
const Home = () => import('~/pages/home/home').then(m => m.default || m)
// dashboard
const Dahsboard = () => import('~/layouts/default').then(m => m.default || m)
const SettingsProfile = () =>
  import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () =>
  import('~/pages/settings/password').then(m => m.default || m)

const Salary = () => import('~/pages/salary/salary').then(m => m.default || m)
const Users = () => import('~/pages/users/user').then(m => m.default || m)
const Attendances = () =>
  import('~/pages/attendance/attendance').then(m => m.default || m)
const AttendanceCalendar = () =>
  import('~/pages/attendance/attendanceCalendar').then(m => m.default || m)
const Holidays = () =>
  import('~/pages/holidays/holiday').then(m => m.default || m)
const Positions = () =>
  import('~/pages/positions/position').then(m => m.default || m)
const Reports = () => import('~/pages/reports/report').then(m => m.default || m)

export default [
  {
    path: '/',
    name: 'welcome',
    components: {
      navbar: Navbar,
      default: Welcome
    }
  },
  {
    path: '/login',
    name: 'login',
    components: {
      navbar: Navbar,
      default: Login
    }
  },
  {
    path: '/register',
    name: 'register',
    components: {
      navbar: Navbar,
      default: Register
    }
  },
  {
    path: '/password/reset',
    name: 'password.request',
    components: {
      navbar: Navbar,
      default: PasswordEmail
    }
  },
  {
    path: '/password/reset/:token',
    name: 'password.reset',
    components: {
      navbar: Navbar,
      default: PasswordReset
    }
  },
  {
    path: '/dashboard',
    component: Dahsboard,
    children: [
      {
        path: '',
        name: 'home',
        component: Home
      },
      {
        path: 'profile',
        name: 'settings.profile',
        component: SettingsProfile
      },
      {
        path: 'password',
        name: 'settings.password',
        component: SettingsPassword
      },
      {
        path: 'salary',
        name: 'dashboard.salary',
        component: Salary
      },
      {
        path: 'users',
        name: 'dashboard.users',
        component: Users
      },
      {
        path: 'attendance',
        name: 'dashboard.attendance',
        component: Attendances
      },
      {
        path: 'attendance/calendar',
        name: 'dashboard.attendanceCalendar',
        component: AttendanceCalendar
      },
      {
        path: 'holidays',
        name: 'dashboard.holidays',
        component: Holidays
      },
      {
        path: 'positions',
        name: 'dashboard.positions',
        component: Positions
      },
      {
        path: 'reports',
        name: 'dashboard.reports',
        component: Reports
      }
    ]
  },

  {
    path: '*',
    component: NotFound
  }
]
