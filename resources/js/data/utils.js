import {
  GET
} from '../plugins/axios'
import {
  POSITION_DRODOWN,
  ROLE_DRODOWN,
  USER_DROPDOWN
} from '../const/api'

export const userPositionDrodownJson = async () => {
  let {
    data
  } = await GET(POSITION_DRODOWN)
  return data
}

export const roleDropDownJson = async () => {
  let {
    data
  } = await GET(ROLE_DRODOWN)
  return data
}

export const userDropDownJsonWithAll = async () => {
  let {
    data
  } = await GET(USER_DROPDOWN)
  data.unshift({
    'label': 'ALL',
    'value': 'ALL'
  })
  return data
}
export const userDropDownJson = async () => {
  let {
    data
  } = await GET(USER_DROPDOWN)
  return data
}
