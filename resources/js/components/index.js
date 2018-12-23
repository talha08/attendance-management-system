import Vue from 'vue'
import Card from './Card'
import Button from './Button'
import Checkbox from './Checkbox'
import Sidebar from './Sidebar.vue'
import {
  HasError,
  AlertError,
  AlertSuccess
} from 'vform'

// Components that are registered globaly.
[
  Card,
  Button,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  Sidebar
].forEach(Component => {
  Vue.component(Component.name, Component)
})
