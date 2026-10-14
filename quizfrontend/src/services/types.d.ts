export type APIResponse<T> = {
  success: boolean
  data: T
  status?: number
}
