# Smart Parking Web Application

Welcome to the Smart Parking Web Application! This system is designed to address urban parking challenges by allowing users to book parking slots in advance and providing real-time information on slot availability.

## System Overview

- **User Booking:** Users can easily book parking slots by providing their name, mobile number, NIC number, and car number.

- **Admin Dashboard:** Admin users have access to a dashboard for monitoring parking slot statuses and viewing user booking information.

- **User Accounts:** Users can create accounts for personalized experiences and tracking their parking history.

- **Online Payments:** The application supports online payments using a mock payment API.

## Getting Started

### Prerequisites

- PHP (>= 7.0)
- MySQL or MariaDB
- Web server (e.g., Apache, Nginx)

### Installation Steps

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/your-username/smart-parking.git
    ```

2. **Database Setup:**

    - Create a new database named `parking_system`.
    - Import the SQL schema from `database/schema.sql`.

3. **Configure Database Connection:**

    - Open `config.php` and update the database connection details.

4. **Run the Application:**

    - Place the project in your web server's document root.
    - Open the web browser and navigate to the project's URL.

## Additional Features

### Parking History

Users can view their past parking bookings, including details such as slot number, booking time, and payment status. To access this feature, navigate to the "History" page.

### Implementation Details

For detailed information on system implementation, code modifications, and additional features, please refer to the [Implementation](IMPLEMENTATION.md) document.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
