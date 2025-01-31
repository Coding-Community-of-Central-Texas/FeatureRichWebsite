document.addEventListener('DOMContentLoaded', async function () {
    const apiKey = '7d177941be70db2266892136f451a28e'; // Replace with your actual Weatherstack API key
    const location = 'New York'; // You can change this to any location
    const url = `https://api.weatherstack.com/current?access_key=${apiKey}&query=${location}`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.error) {
            document.getElementById('location').textContent = 'Error loading weather data';
            return;
        }

        const locationName = data.location.name;
        const temperature = data.current.temperature;
        const description = data.current.weather_descriptions[0];

        document.getElementById('location').textContent = locationName;
        document.getElementById('temperature').textContent = `${temperature}°C`;
        document.getElementById('description').textContent = description;
    } catch (error) {
        console.error('Error fetching weather data:', error);
        document.getElementById('location').textContent = 'Error loading weather data';
    }
});