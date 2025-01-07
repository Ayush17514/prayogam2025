import Redis from 'ioredis';

// Create a new Redis connection using environment variables
const redis = new Redis({
  host: process.env.REDIS_HOST,    // Redis host (set this in Vercel environment variables)
  port: process.env.REDIS_PORT,    // Redis port (usually 6379)
  password: process.env.REDIS_PASSWORD,  // Redis password (if needed)
});

export default async function handler(req, res) {
  if (req.method === 'POST') {
    const { username, email } = req.body;

    // Validate input
    if (!username || !email) {
      return res.status(400).json({ message: 'Username and email are required.' });
    }

    try {
      // Process the registration (e.g., store the data in Redis)

      // If registration is successful:
      return res.status(200).json({ message: 'Registration successful!' });

    } catch (error) {
      console.error(error);
      // Send a proper error response in case of failure
      return res.status(500).json({ message: 'Failed to register user. Please try again later.' });
    }
  } else {
    // Return Method Not Allowed error if it's not a POST request
    return res.status(405).json({ message: 'Method Not Allowed' });
  }
}
