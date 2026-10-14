export type User = {
  user: User
  id: number
  username: string
  email: string
  role: string
  access_token?: string

  role?: string
}

export interface APIResponse<T> {
  success: boolean
  content: T // Contient le contenu de la réponse, qui est de type T
  status?: number
}

export type InputCreateUser = {
  id: number
  username: string
  email: string
  password: string
}

export type InputUpdateUser = {
  id: number
  username: string
  email: string
  password: string
}

export type InputLoginUser = {
  email: string
  username: string
  password: string
}
