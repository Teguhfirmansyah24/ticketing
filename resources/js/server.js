const ngrok = require('@ngrok/ngrok');
const express = require('express');

const app = express();

app.get('/', (req, res) => {
    res.send('Ngrok is working!');
});

const PORT = 3000;

app.listen(PORT, async () => {
    console.log(`Local server running on port ${PORT}`);

    try {
        // Start ngrok tunnel
        const listener = await ngrok.connect({
            addr: PORT,
            authtoken: 'YOUR_NGROK_TOKEN'
        });

        console.log(`Public URL: ${listener.url()}`);
    } catch (err) {
        console.error(err);
    }
});