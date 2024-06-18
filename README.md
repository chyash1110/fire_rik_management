# Fire Risk Management System

## Overview

The Fire Risk Management System is designed to predict and manage forest fire incidents. It includes a machine learning model to predict the spread time of fires, a web application for reporting and managing fire incidents, and transportation services for firefighting resources.

## Features

- **Fire Spread Prediction**: Uses a Random Forest Regression model to predict the time it will take for a fire to spread.
- **Incident Reporting**: Web interface for reporting new fire incidents, updating their status, and viewing historical fire data.
- **Transportation Booking**: Allows booking of transportation services for firefighting resources.

## Installation

### Prerequisites

- Python 3.6+
- Flask
- scikit-learn
- Joblib
- Pandas
- Numpy
- MySQL

### Steps

1. Clone the repository:
   ```sh
   git clone https://github.com/chyash1110/fire_risk_management.git
   ```
2. Install the required Python packages:
   ```sh
   pip install -r requirements.txt
   ```
3. Set up the MySQL database and import the schema from `schema.sql` (not provided here, ensure you have the schema file).

4. Configure the database connection in `config.php`:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "fire_management";
   $weather_api_key = "your_openweathermap_api_key";
   ```

## Usage

### Running the Web Application

1. Navigate to the `Fire_Spread_Model` directory and run the Flask application:
   ```sh
   cd Fire_Spread_Model
   python app.py
   ```
2. The application will be accessible at `http://127.0.0.1:5000`.

### Reporting and Managing Fire Incidents

- **Add Fire Incident**: Use the form on the `dashboard_forest.php` to report a new fire incident.
- **Update Fire Status**: Update the status of an existing fire incident using the form on the same dashboard.
- **View Fire Data**: View current and historical fire incidents on the dashboards for different user roles.

### Predicting Fire Spread

Use the `/predict` endpoint of the Flask app to predict fire spread time. Example usage:
```sh
curl -X POST http://127.0.0.1:5000/predict -H "Content-Type: application/json" -d '{
  "temperature": 30,
  "humidity": 40,
  "wind_speed": 5,
  "distance": 10,
  "terrain_type": "hilly",
  "vegetation_type": "forest"
}'
```

## File Structure

- `Fire_Spread_Model/`: Contains the machine learning model and Flask app.
  - `RandomForestRegression.ipynb`: Jupyter notebook for training the fire spread model.
  - `app.py`: Flask application for predicting fire spread.
  - `forest_fire_model.pkl`: Serialized Random Forest model.
  - `scaler.pkl`: Scaler for feature normalization.
- `data/`: Contains data files.
  - `forest_fire_spread_data.csv`: Dataset used for training the model.
  - `vegetation.json`: JSON file with vegetation type data.
- `css/`: Stylesheets for the web application.
- `js/`: JavaScript files for the web application.
- `*.php`: PHP scripts for various functionalities like adding incidents, managing transportation, and dashboards.

## Contributing

Contributions are welcome. Please fork the repository and create a pull request with your changes.
