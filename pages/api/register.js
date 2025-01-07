import Redis from 'ioredis';

// Create a new Redis connection using environment variables
const redis = new Redis({
  host: process.env.REDIS_HOST,    // Redis host (set this in Vercel environment variables)
  port: process.env.REDIS_PORT,    // Redis port (usually 6379)
  password: process.env.REDIS_PASSWORD,  // Redis password (if needed)
});

export default async function handler(req, res) {
  // Only allow POST requests for registration
  if (req.method === 'POST') {
    const { username, email } = req.body;

    // Validate input
    if (!username || !email) {
      return res.status(400).json({ message: 'Username and email are required.' });
    }

    try {
      // Store registration data in Redis using a unique key based on the username
      const userId = `user:${username}`;
      const userData = {
        username,
        email,
      };

      // Save the user data in Redis as a hash (field-value pairs)
      await redis.hmset(userId, userData);

      // Respond with success
      return res.status(200).json({ message: 'Registration successful!' });
    } catch (error) {
      console.error(error);
      return res.status(500).json({ message: 'Failed to register user. Please try again later.' });
    }
  } else {
    // Return Method Not Allowed error if it's not a POST request
    return res.status(405).json({ message: 'Method Not Allowed' });
  }
}
