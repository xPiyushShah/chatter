import { messageModel } from "../models/messageModel.js";
import { userModel } from "../models/userModel.js";
import moment from "moment-timezone";

export const socketHandler = (io) => {
  const clients = {};

  io.on("connection", (socket) => {
    console.log(`${socket.id} connected at ${new Date().toTimeString()}`);

    const userID = socket.handshake.query.userID;
    console.log(userID);

    if (userID) {
      clients[userID] = socket.id; // Store socket id with userId
      console.log(`User ${userID} is online with socket id ${socket.id}`);
      console.log(`Total ${Object.keys(clients).length} users are online.`);
    }

    socket.emit("welcome", `Dear ${socket.id} Welcome to the server`);
    socket.broadcast.emit("welcome", `${socket.id} joined the server`);
    io.emit("activeUsers", Object.keys(clients));

    // Sending a message to a specific recipient using socket ID
    socket.on(
      "sendMessage",
      ({
        message,
        sender,
        recipient,
        senderFullName,
        recipientFullName,
        time,
        senderDp,
      }) => {
        const recipientSocketID = clients[recipient];

        if (recipientSocketID) {
          socket.broadcast.to(recipientSocketID).emit("receiveMessage", {
            message,
            sender,
            recipient,
            senderFullName,
            recipientFullName,
            time,
            senderDp,
          });
        } else {
          console.log(`User ${recipient} is offline. Message saved in DB.`);
        }

        messageModel.create({ message, sender, recipient });
      }
    );

    // Handle disconnection and cleanup

    socket.on("disconnect", async () => {
      console.log(`${socket.id} disconnected at ${new Date().toTimeString()}`);

      if (userID) {
        // Get the current time in the desired time zone (Asia/Kolkata)
        const lastseen = moment().tz("Asia/Kolkata").toDate(); // Store the raw date object
        io.emit("lastseen", { userID, lastseen });
        console.log(`${userID} disconnected at ${lastseen}`);

        // Save the raw date in the database
        await userModel.findByIdAndUpdate(userID, {
          $set: { lastseen: lastseen }, // Save the raw date/time
        });

        // Remove user from active clients
        delete clients[userID];
      }

      // Emit updated active users list
      io.emit("activeUsers", Object.keys(clients));

      console.log(`Total ${Object.keys(clients).length} users are online.`);
    });

    console.log(`Total ${Object.keys(clients).length} users are online.`);
  });
};
