from flask import Flask, request, jsonify
import pandas as pd
from sklearn.ensemble import RandomForestRegressor
from sklearn.preprocessing import StandardScaler
import joblib
import numpy as np

app = Flask(__name__)

# Load the trained model and the scaler
model = joblib.load('Fire_Spread_Model/forest_fire_model.pkl')
scaler = joblib.load('Fire_Spread_Model/scaler.pkl')

# Define the encoding functions
def encode_terrain_type(terrain_type):
    return {'flat': 0, 'hilly': 1, 'mountainous': 2}.get(terrain_type, 0)

def encode_vegetation_type(vegetation_type):
    return {'shrubland': 0, 'grass': 1, 'forest': 2}.get(vegetation_type, 0)

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()

    temperature = data['temperature']
    humidity = data['humidity']
    wind_speed = data['wind_speed']
    distance = data['distance']
    terrain_type = encode_terrain_type(data['terrain_type'])
    vegetation_type = encode_vegetation_type(data['vegetation_type'])

    # Prepare features
    features = np.array([[temperature, humidity, wind_speed, distance, terrain_type, vegetation_type]])

    # Scale the features
    features_scaled = scaler.transform(features)

    # Make prediction
    spread_time = model.predict(features_scaled)[0]
    spread_time = round(spread_time, 2)
    return jsonify({'spread_time': spread_time})

if __name__ == '__main__':
    app.run(debug=True)
