import time

from bs4 import BeautifulSoup

import json
import webbrowser as w

# import msvcrt as m
from selenium import webdriver

options = webdriver.ChromeOptions()
options.headless = True
options.add_argument("--no-sandbox")
options.add_argument("--disable-dev-shm-usage")
options.add_argument("window-size=2560x1600")
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC


base_url = "https://klas.kw.ac.kr/"

user_id = input("hak bun:")

user_pw = input("password:")

browser = webdriver.Chrome("./chromedriver", options=options)
browser.get(base_url)
elem = browser.find_element_by_id("loginId")
elem.send_keys(user_id)
elem = browser.find_element_by_id("loginPwd")
elem.send_keys(user_pw)
time.sleep(2)
elem = browser.find_element_by_xpath("/html/body/div[1]/div/div/div[2]/form/div[2]/button")
elem.click()


elem = WebDriverWait(browser, 10).until(EC.presence_of_element_located((By.XPATH, "//*[@id='appModule']/div/div[1]/div[1]/select")))
main_url = browser.current_url
soup = BeautifulSoup(browser.page_source, "lxml")

browser.get_screenshot_as_file("klas.png")
subjects = soup.find('ul', attrs={'class': 'subjectlist listbox'})

tag = soup.find_all("p", attrs={'class': 'title-text'})

print(tag[0].get_text())
for subject in subjects:
    title = subject.find("div", attrs={'class': 'left'}).get_text()
    print(title)

browser.quit()

