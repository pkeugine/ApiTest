import requests

LOGIN_INFO = {
    #'userid': myusername,
    #'password': mypassword,
    'redirect': '/',
}
login_url = 'https://kw.everytime.kr/login'
api_url = 'https://api.everytime.kr'

# create session
with requests.Session() as s:
    login_res = s.post(login_url, data=LOGIN_INFO)
    if login_res.status_code != 200:
        print("failed")
    else:
        print("good")
