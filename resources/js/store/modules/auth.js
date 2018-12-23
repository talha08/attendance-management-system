import axios from 'axios'
import Cookies from 'js-cookie'
import Types from '../types'
import { FETCH_USER, LOGOUT } from '../../const/api'

const auth = {
  // state
  state: {
    user: null,
    token: Cookies.get('token')
  },

  // getters
  getters: {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null
  },

  // mutations
  mutations: {
    [Types.mutations.SAVE_TOKEN] (state, { token, remember }) {
      state.token = token
      Cookies.set('token', token, { expires: remember ? 365 : null })
    },

    [Types.mutations.FETCH_USER_SUCCESS] (state, { user }) {
      state.user = user
    },

    [Types.mutations.FETCH_USER_FAILURE] (state) {
      state.token = null
      Cookies.remove('token')
    },

    [Types.mutations.LOGOUT] (state) {
      state.user = null
      state.token = null
      Cookies.remove('token')
    },

    [Types.mutations.UPDATE_USER] (state, { user }) {
      state.user = user
    }
  },
  // actions
  actions: {
    [Types.actions.ACTION_SAVE_TOKEN] ({ commit, dispatch }, payload) {
      commit(Types.mutations.SAVE_TOKEN, payload)
    },

    async [Types.actions.ACTION_FETCH_USER] ({ commit }) {
      try {
        const { data } = await axios.get(FETCH_USER)
        commit(Types.mutations.FETCH_USER_SUCCESS, { user: data })
      } catch (e) {
        commit(Types.mutations.FETCH_USER_FAILURE)
      }
    },

    [Types.actions.ACTION_UPDATE_USER] ({ commit }, payload) {
      commit(Types.mutations.UPDATE_USER, payload)
    },

    async [Types.actions.ACTION_LOGOUT] ({ commit }) {
      try {
        await axios.post(LOGOUT)
      } catch (e) { }
      commit(Types.mutations.LOGOUT)
    }

  }
}

export default auth
