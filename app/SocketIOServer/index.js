var app = require("express")();
var http = require("http").Server(app);
var io = require("socket.io")(http);

const port = 6800;

app.get("/", function(req, res) {
  res.sendFile(__dirname + "/index.html");
});

const getOnlineUsers = () => {
  let clients = io.sockets.clients().connected;
  let sockets = Object.values(clients);
  let users = sockets.map(s => s.user);
  return users.filter(u => u != undefined);
};


io.on("connection", function(socket) {

  socket.on("online_users", () => {
    socket.emit("users", getOnlineUsers());
  });

  socket.on("join_room", ({room,user}) => {
    socket.user = user;
    socket.join(room);
  });

  socket.on("message", ({ room, message }) => {
    socket.to(room).emit("message", {
      message,
      friend:socket.user,
    });
  });

  socket.on("typing", ({room}) => {
    socket.to(room).emit("typing",{
      user:socket.user
    });
  });

  socket.on("stopped_tying", ({ room }) => {
    socket.to(room).emit("stopped_tying",{
      user:socket.user
    });
  });

});

http.listen(port, function() {
  console.log(`listening on *:${port}`);
});