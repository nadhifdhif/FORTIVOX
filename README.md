# Fortivox

**Fortivox** is an IoT-based environmental monitoring system designed to detect **temperature**, **humidity**, and **gas levels** in real-time and display the data via a responsive web dashboard.

The system is powered by an **ESP32** microcontroller and integrates the following key components:
- **DHT22** sensor for temperature and humidity measurement
- **MQ-2** and **MQ-135** gas sensors for smoke and harmful gas detection
- **16x2 I2C LCD** for local display
- **Relay module** to control a DC fan
- **Passive buzzer** for warning alerts

Sensor data is transmitted via the **MQTT protocol** and stored in a **MySQL** database. A Laravel-based web application visualizes the data with:
- Real-time monitoring dashboard
- Statistical summaries and bar charts
- Alert system for unsafe conditions
- Multilingual support (14 languages including English, Indonesian, French, Japanese, etc.)

Fortivox is suitable for indoor environments such as **homes, laboratories, or workspaces**, providing improved safety, comfort, and accessibility.

