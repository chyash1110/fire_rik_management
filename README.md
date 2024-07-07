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

## Screenshots

### Home Page
![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/7e7b5f78-5f0d-4492-906e-61d557c88648)

### Registration

![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/1bcf9bb0-82ba-4085-ab9d-f25febdae85b)

### Login

![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/cb36dc4a-deb5-4f78-ae57-a474658915b7)

### General Public DashBoard

![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/e6db6db1-3296-4be6-af40-43b5599d3d67)
![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/cfd23a78-fc25-477a-a063-994501a7bbd1)
![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/5130b10e-c1cf-4a49-ad21-c0cb66f246f5)

### Transportation

![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/e79f9960-3c02-40c5-85fc-8461692611d4)
![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/e334f01f-7ae8-483a-99b6-04e6f283065d)


### Forest Department

![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/6d592f7f-58b2-4871-872c-574891dc38bb)
![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/85d1e400-41e3-4d97-9a98-c6b749e6c201)
![image](https://github.com/chyash1110/fire_risk_management/assets/118417410/2738358e-16d1-45da-b113-98696ef61f9c)


## Contributing

Contributions are welcome. Please fork the repository and create a pull request with your changes.
