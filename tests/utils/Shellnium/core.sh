#!/bin/bash

ROOT=http://localhost:9515
GET='curl -s -X GET'
POST='curl -s -X POST -H "Content-Type: application/json"'
DELETE='curl -s -X DELETE'
BASE_PATH=$1

##############################
# Session
##############################

new_session() {
  local chromeOptions=$(for i in "${CHROMEOPTIONS[@]}"; do printf "\"${i}\",";done | sed 's/,$//')

  $POST -d '{
    "desiredCapabilities": {
      "browserName":"chrome",
      "chromeOptions": {"args": ['${chromeOptions}'] }
    }
  }' ${ROOT}/session | ${BASE_PATH}/jq -r '.sessionId'
}

delete_session() {
  $DELETE ${BASE_URL} > /dev/null
}

get_cookies() {
	$GET ${BASE_URL}/cookie | ${BASE_PATH}/jq -r '.value[]'
}

set_cookies() {
	local cookie=$1
	$POST -d "{\"cookie\": $cookie}" ${BASE_URL}/cookie >/dev/null
}

delete_cookies() {
  	$DELETE ${BASE_URL}/cookie > /dev/null
}

##############################
# Navigate
##############################

navigate_to() {
  local url=$1
  $POST -d '{"url":"'${url}'"}' ${BASE_URL}/url >/dev/null
}

get_current_url() {
  $GET ${BASE_URL}/url | ${BASE_PATH}/jq -r '.value'
}

get_title() {
  $GET ${BASE_URL}/title | ${BASE_PATH}/jq -r '.value'
}

back() {
  $POST ${BASE_URL}/back >/dev/null
}

forward() {
  $POST ${BASE_URL}/forward >/dev/null
}

refresh() {
  $POST ${BASE_URL}/refresh >/dev/null
}

##############################
# Timeouts
##############################
get_timeouts() {
  $GET ${BASE_URL}/timeouts | ${BASE_PATH}/jq -r '.value'
}

set_timeouts() {
  local script=$1
  local pageLoad=$2
  local implicit=$3
  $POST -d "{\"script\": $script, \"pageLoad\": $pageLoad, \"implicit\": $implicit}" ${BASE_URL}/timeouts >/dev/null
}

set_timeout_script() {
  local script=$1
  $POST -d "{\"script\": $script}" ${BASE_URL}/timeouts >/dev/null
}

set_timeout_pageLoad() {
  local pageLoad=$1
  $POST -d "{\"pageLoad\": $pageLoad}" ${BASE_URL}/timeouts >/dev/null
}

set_timeout_implicit() {
  local implicit=$1
  $POST -d "{\"implicit\": $implicit}" ${BASE_URL}/timeouts >/dev/null
}

##############################
# Element Retrieval
##############################

#
# $property:
#   - "id"
#   - "name"
#   - "css selector"
#   - "link text"
#   - "partial link text"
#   - "tag name"
#   - "class name"
#   - "xpath"
#
find_element() {
  local property=$1
  local value=$2
  $POST -d "{\"using\":\"$property\", \"value\": \"$value\"}" ${BASE_URL}/element | ${BASE_PATH}/jq -r '.value.ELEMENT'
}

find_elements() {
  local property=$1
  local value=$2
  $POST -d "{\"using\":\"$property\", \"value\": \"$value\"}" ${BASE_URL}/elements | ${BASE_PATH}/jq -r '.value[].ELEMENT'
}

find_element_from_element() {
  local elementId=$1
  local property=$2
  local value=$3
  $POST -d "{\"using\":\"$property\", \"value\": \"$value\"}" ${BASE_URL}/element/${elementId}/element | ${BASE_PATH}/jq -r '.value.ELEMENT'
}

find_elements_from_element() {
  local elementId=$1
  local property=$2
  local value=$3
  $POST -d "{\"using\":\"$property\", \"value\": \"$value\"}" ${BASE_URL}/element/${elementId}/elements | ${BASE_PATH}/jq -r '.value[].ELEMENT'
}

get_active_element() {
  $GET ${BASE_URL}/element/active | ${BASE_PATH}/jq -r '.value.ELEMENT'
}

get_alert_text() {
  $GET ${BASE_URL}/alert/text | ${BASE_PATH}/jq -r '.value'
}

##############################
# Element State
##############################

get_attribute() {
  local elementId=$1
  local name=$2
  $GET ${BASE_URL}/element/${elementId}/attribute/${name} | ${BASE_PATH}/jq -r '.value'
}

get_property() {
  local elementId=$1
  local name=$2
  $GET ${BASE_URL}/element/${elementId}/property/${name} | ${BASE_PATH}/jq -r '.value'
}

get_css_value() {
  local elementId=$1
  local propertyName=$2
  $GET ${BASE_URL}/element/${elementId}/css/${propertyName} | ${BASE_PATH}/jq -r '.value'
}

get_text() {
  local elementId=$1
  $GET ${BASE_URL}/element/${elementId}/text | ${BASE_PATH}/jq -r '.value'
}

get_tag_name() {
  local elementId=$1
  $GET ${BASE_URL}/element/${elementId}/name | ${BASE_PATH}/jq -r '.value'
}

get_rect() {
  local elementId=$1
  $GET ${BASE_URL}/element/${elementId}/rect | ${BASE_PATH}/jq -r '.value'
}

is_element_enabled() {
  local elementId=$1
  $GET ${BASE_URL}/element/${elementId}/enabled | ${BASE_PATH}/jq -r '.value'
}

##############################
# Element Interaction
##############################

send_keys() {
  local elementId=$1
  local value=$2
  $POST -d "{\"value\": [\"${value}\"]}" ${BASE_URL}/element/${elementId}/value >/dev/null
}

send_alert_text() {
  local value=$1
  $POST -d "{\"value\": [\"${value}\"]}" ${BASE_URL}/alert/text >/dev/null
}

click() {
  local elementId=$1
  $POST ${BASE_URL}/element/${elementId}/click >/dev/null
}

element_clear() {
  local elementId=$1
  $POST ${BASE_URL}/element/${elementId}/clear >/dev/null
}

##############################
# Document
##############################

get_source() {
	$GET ${BASE_URL}/source
}

exec_script() {
  $POST -d "{\"script\": \"$1\", \"args\":[\"$2\"]}" ${BASE_URL}/execute/sync
}

element_screenshot() {
  local elementId=$1
  local path=${2:-./screenshot.png}
  $GET ${BASE_URL}/element/${elementId}/screenshot | ${BASE_PATH}/jq -r '.value' | base64 -d > $path
}

screenshot() {
  local path=${1:-./screenshot.png}
  $GET ${BASE_URL}/screenshot | ${BASE_PATH}/jq -r '.value' | base64 -d > $path
}


##############################
# Context
##############################

get_window_handle() {
  $GET ${BASE_URL}/window | ${BASE_PATH}/jq -r '.value'
}

get_window_handles() {
  $GET ${BASE_URL}/window/handles | ${BASE_PATH}/jq -r '.value[]'
}

delete_window() {
  curl -s -X DELETE ${BASE_URL}/window
}

new_window() {
  local type=$1 # 'tab' or 'window'
  $POST -d "{\"type\":\"$type\"}" ${BASE_URL}/window/new | ${BASE_PATH}/jq -r '.value.handle'
}

switch_to_window() {
  local handle=$1
  $POST -d "{\"name\":\"$handle\"}" ${BASE_URL}/window >/dev/null
}

#
# param is
#   - element
#   - integer
#   - id
#
switch_to_frame() {
  local id=$1
  local param="{\"id\":\"$id\"}"

  # is element
  local frameId=$(get_attribute $id 'id')
  if ! echo $frameId | grep "stale element reference" >/dev/null ; then
    $POST -d "{\"id\":\"$frameId\"}" ${BASE_URL}/frame >/dev/null
    return
  fi

  if expr "$id" : "[0-9]*$" >&/dev/null;then # is integer
    $POST -d "{\"id\":$id}" ${BASE_URL}/frame >/dev/null
  else # is id
    $POST -d "{\"id\":\"$id\"}" ${BASE_URL}/frame >/dev/null
  fi
}

switch_to_parent_frame() {
  $POST ${BASE_URL}/frame/parent >/dev/null
}

dismiss_alert() {
  local handle=$1
  $POST ${BASE_URL}/alert/dismiss >/dev/null
}

accept_alert() {
  local handle=$1
  $POST ${BASE_URL}/alert/accept >/dev/null
}

get_window_rect() {
  $GET ${BASE_URL}/window/rect | ${BASE_PATH}/jq -r '.value'
}

set_window_rect() {
  local x=$1
  local y=$2
  local width=$3
  local height=$4
  $POST -d "{\"x\": $x, \"y\": $y, \"width\": $width, \"height\": $height}" ${BASE_URL}/window/rect | ${BASE_PATH}/jq -r '.value'
}

maximize_window() {
  $POST ${BASE_URL}/window/maximize | ${BASE_PATH}/jq -r '.value'
}

minimize_window() {
  $POST ${BASE_URL}/window/minimize | ${BASE_PATH}/jq -r '.value'
}

fullscreen_window() {
  $POST ${BASE_URL}/window/fullscreen | ${BASE_PATH}/jq -r '.value'
}
