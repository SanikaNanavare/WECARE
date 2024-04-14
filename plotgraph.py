import pandas as pd
import numpy as np
from sklearn.linear_model import LinearRegression
import matplotlib.pyplot as plt

# Function to fetch or update health data 
def fetch_health_data():
   
    data = {
        'Sugar': [120, 130, 110, 140, 160],
        'BP': [120, 130, 110, 140, 120],
        'HeartRate': [70, 80, 75, 90, 85],
        'Cholesterol': [200, 220, 190, 240, 210]
    }
    return pd.DataFrame(data)

# Function to perform linear regression and plot the graph
def plot_health_data_linear_regression(health_data, feature_name):
    # Extract the feature and target variables
    X = health_data.index.values.reshape(-1, 1)
    y = health_data[feature_name].values.reshape(-1, 1)

    # Create and train the linear regression model
    model = LinearRegression()
    model.fit(X, y)

    # Make predictions using the model
    predictions = model.predict(X)

    # Plot the original data and linear regression line
    plt.scatter(X, y, color='blue', label='Actual Data')
    plt.plot(X, predictions, color='red', linewidth=2, label='Linear Regression')
    plt.xlabel('Sample Index')
    plt.ylabel(feature_name)
    plt.title(f'Linear Regression for {feature_name}')
    plt.legend()
    plt.show()

# Main script
if __name__ == "__main__":
    # Fetch or update health data
    health_data = fetch_health_data()

    # Display the original data
    print("Original Health Data:")
    print(health_data)

    # Example: Perform linear regression and plot for 'Sugar' levels
    feature_name = 'Sugar'
    plot_health_data_linear_regression(health_data, feature_name)
