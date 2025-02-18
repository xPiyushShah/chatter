+-------------------+          +---------------------+
|    User A         |          |     User B          |
| (Initiator)       |          | (Receiver)          |
+-------------------+          +---------------------+
         |                           |
         |   1. Initiates Call       |
         |   (Offer via WebSocket)   |
         | ------------------------> |
         |                           |
         |   2. Receives Offer      |
         | <------------------------ |
         |                           |
         |   3. Sends Answer        |
         |   (Answer via WebSocket) |
         | ------------------------> |
         |                           |
         |   4. ICE Candidates      |
         | ------------------------> |
         |   (STUN/TURN Handling)   |
         |                           |
         |   5. Establish Peer      |
         |   Connection             |
         | ------------------------> |
         |                           |
         |   6. Start Video Call    |
         |                           |
         | <------------------------ |
         |                           |
         |   7. End Call            |
         | ------------------------> |
         |                           |
         |   8. Update Call Log     |
         |    (ended status)        |
         | ------------------------> |
