'use strict';

var ws = new WebSocket('ws://192.168.1.21:8082');

ws.onopen = (e) => {
  console.log("websocket opened");
}
