#!/bin/bash

# Cập nhật hệ thống
sudo apt-get update

# Cài đặt các gói cần thiết để cài đặt Docker
sudo apt-get install -y apt-transport-https ca-certificates curl software-properties-common

# Thêm khóa GPG của Docker
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Thêm Docker repository vào danh sách nguồn
echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Cập nhật lại danh sách nguồn
sudo apt-get update

# Cài đặt Docker Engine
sudo apt-get install -y docker-ce docker-ce-cli containerd.io

# Cài đặt Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Kiểm tra phiên bản Docker và Docker Compose
docker --version
docker-compose --version