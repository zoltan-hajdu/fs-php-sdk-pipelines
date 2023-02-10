#!/bin/bash

declare -a CHROMEOPTIONS
CHROMEOPTIONS=( # we can set the options for the chromedriver
  "enable-automation"
  "--headless" # browser is not visible
  "--no-sandbox"
  "--disable-setuid-sandbox"
  "--disable-dev-shm-usage"
  "--disable-browser-side-navigation"
  "--disable-webgl"
  "--disable-gpu"
  "--disable-xss-auditor"
  "--disable-web-security"
  "--allow-running-insecure-content"
  "--disable-popup-blocking"
  "--ignore-certificate-errors"
  "--no-default-browser-check"
)
export CHROMEOPTIONS

time=0

. "$3/selenium.sh" $3

main() {
  SECONDS=0
  script=20000
  pageLoad=4000
  implicit=5000
  set_timeouts ${script} ${pageLoad} ${implicit}
  maximize_window
  page_loader $1
  echo '{"message":"Navigated to URL","url":"'$1'","error":false,}'
  wait_for_spinner "Page is ready"
  click $(find_element 'xpath' "//input[@name='login']")
  exec_script "document.getElementsByName('login')[0].value = '';"
  sleep 1
  send_keys $(find_element 'xpath' "//input[@name='login']") $2
  click $(find_element 'xpath' "//button[text()='Connect']")
  wait_for_spinner "Redirects to SMS validation page"
  local url=$(get_current_url)
  if [[ $url == *"404"* ]]; then # if there is an error in FS side and we are on the "pig" page
    echo '{"message":"Account number not found","url":"'$url'","error":true}'
    sleep 2
  elif [[ $url == *"connection-failure"* ]]; then # OOps! error
    echo '{"message":"Oops! It appears that you are having difficulty connecting to you account.","url":"'$url'","error":true}'
    sleep 2
  elif [[ $url == *"location-failure"* ]]; then # Sorry! We are unable to process your request due to one or a combination of errors listed below:
                                                 # Purchase currency is other than Canadian Dollar
                                                 # Indicated shipping address is located outside of Canada
                                                 # Indicated billing address is located outside of Canada
    echo '{"message":"Sorry! We are unable to process your request due to an error.","url":"'$url'","error":true}'
    sleep 2
  else # SMS validation page
    click $(find_element 'xpath' "//input[@id='sixDigits']")
    element_clear $(find_element 'xpath' "//input[@id='sixDigits']")
    send_keys $(find_element 'xpath' "//input[@id='sixDigits']") "123456"
    wait_for_spinner "SMS validation code entered"
    click $(find_element 'xpath' "//button[text()='Proceed']")
    wait_for_spinner "Proceed button pushed"
  fi
  delete_session
  ELAPSED=$((SECONDS % 60))
  echo '{"message":"Script running time","elapsed":"'$ELAPSED' seconds"}'
}

page_loader() {
  if [[ $time == 0 ]]; then
    navigate_to $1
    sleep 1
  fi
  local spinner=$(find_element 'xpath' "//div[@id='sto-progressbar']")
  if [[ $spinner == "null" ]]; then
    time=$((time+1))
    if [[ $time > 3 ]]; then
      time=0
      page_loader $1
    else
      sleep 1
      page_loader $1
    fi
  else
    echo '{"message":"Page loaded","elapsed":"'$time' seconds"}'
    time=0
  fi
}

wait_for_spinner() {
  local message="$1"
  local spinner=$(find_element 'xpath' "//div[@id='sto-progressbar']")
  if [[ $spinner == "null" ]]; then
    time=$((time+1))
    sleep 1
    wait_for_spinner "$message"
  else
    local spinnerClass=$(get_attribute ${spinner} "class")
    if [[ $spinnerClass == "showSpinner" ]]; then
      time=$((time+1))
      sleep 1
      wait_for_spinner "$message"
    else
      echo '{"message":"Spinner is ready","action":"'$message'","elapsed":"'$time' seconds"}'
      time=0
    fi
  fi
}
main $1 $2
