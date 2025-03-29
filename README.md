# Project

## Introduction
Notes Manager is a simple web application built with PHP 8.3. It runs in a Docker environment using Docker Compose and serves HTTP traffic through an Nginx server. The project uses PostgreSQL as its database.

## Installation 
1. Clone the repository:
   ```sh
   git clone https://github.com/xpawk/notes_manager_wdpai.git
   cd project
   ```
2. Start the containers:
   ```sh
   docker compose up -d
   ```
3. The project will be available at:
   ```
   http://localhost
   ```

## Structure
```
/project
│── docker/
│   │── db/
│   │   ├── Dockerfile  # Database docker configuration
│   │── nginx/
│   │   ├── Dockerfile  # Nginx docker configuration
│   │   ├── nginx.conf  # Nginx configuration
│   │── php/
│   │   ├── Dockerfile    # PHP 8.3 docker configuration
│── src/
│   ├── index.php        # Application entry file
│── docker-compose.yml   # Docker Compose service definitions
│── README.md            # Project documentation
```


