const express = require('express');
const axios = require('axios');

const app = express();


app.use((req, res, next) => {
    res.setHeader(
      'Content-Security-Policy',
      "default-src 'self'; script-src 'self' 'unsafe-inline'; worker-src blob:; style-src 'self' 'unsafe-inline';"
    );
    next();
  });

  app.use(express.static('public'));
const port = 3000; // Choose any port you prefer

// Endpoint to fetch cryptocurrency prices
app.get('/prices', async (req, res) => {
  try {
    // Replace 'YOUR_API_KEY' with your actual CoinGecko API key
    const apiKey = 'CG-RBsUVxGbNZRJ14dwueUoDGg6';
    const apiUrl = `https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd&api_key=${apiKey}`;

    // Make the request to CoinGecko API
    const response = await axios.get(apiUrl);
    const bitcoinPrice = response.data.bitcoin.usd;

    // Send the response with the Bitcoin price
    res.json({ bitcoinPrice });
  } catch (error) {
    console.error('Error fetching cryptocurrency prices:', error);
    res.status(500).json({ error: 'Internal Server Error' });
  }
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
