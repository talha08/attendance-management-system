import store from '~/store'
import Types from '../store/types'
export default async (to, from, next) => {
  if (!store.getters['check'] && store.getters['token']) {
    try {
      await store.dispatch(Types.actions.ACTION_FETCH_USER)
    } catch (e) {}
  }
  next()
}
