import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import App from '~/App'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import '~/plugins'
import '~/components'
import locale from 'element-ui/lib/locale/lang/en'
import FullCalendar from 'vue-full-calendar'
import 'fullcalendar/dist/fullcalendar.min.css'
window._ = require('lodash')
Vue.use(FullCalendar)
Vue.use(ElementUI, {
  locale
})

Vue.config.productionTip = false
/* eslint-disable no-new */
new Vue({
  store,
  router,
  ...App
})
