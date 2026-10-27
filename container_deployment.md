# Run the Library Management System with Podman

These instructions use Podman to build and run the application and its MySQL database in containers.

## 1. Install Podman

### Windows (recommended)

Podman on Windows runs Linux containers inside a Linux virtual machine. Install and enable **WSL 2** first:

1. Open PowerShell as Administrator and install WSL with an Ubuntu Linux distribution:

   ```powershell
   wsl --install -d Ubuntu
   ```

2. Restart Windows if prompted, then launch Ubuntu from the Start menu and complete its first-time setup.
3. Confirm WSL is using version 2:

   ```powershell
   wsl --status
   ```

   If needed, set WSL 2 as the default:

   ```powershell
   wsl --set-default-version 2
   ```

Then install and configure Podman:

1. Download and install [Podman Desktop for Windows](https://podman-desktop.io/docs/installation/windows-install).
2. Open Podman Desktop and follow its setup prompts to install Podman and create a Podman machine. Choose the WSL 2 provider if prompted.
3. Open PowerShell and check that Podman is available:

   ```powershell
   podman --version
   podman machine list
   ```

   If no machine is listed, create and start one:

   ```powershell
   podman machine init
   podman machine start
   ```

Podman uses a Linux virtual machine to run containers on Windows and macOS.

### macOS and Linux

Follow the installation instructions for your operating system in the [official Podman documentation](https://podman.io/docs/installation). On macOS, create and start a Podman machine if the installer has not already done so:

```shell
podman machine init
podman machine start
```

## 2. Install a Compose provider

The commands below use `podman-compose`. Install Python 3 first if it is not already installed, then install the provider:

```shell
python -m pip install podman-compose
```

Check that it is available:

```shell
podman-compose --version
```

## 3. Start the application

Run these commands from the project directory (the directory containing `compose.yaml`):

```shell
podman-compose up -d --build
```

The first run builds the images and starts the database and web application. Check that both containers are running:

```shell
podman ps
```

Wait for the database to finish starting, then check its logs:

```shell
podman logs lib-database-pod
```

Look for `ready for connections`. You can also check that the database tables exist:

```shell
podman exec lib-database-pod mysql -ulib -plibpass library_db -e "SHOW TABLES;"
```

Open the application at [http://localhost:8080](http://localhost:8080). To check the HTTP response from a terminal:

```shell
curl -I http://localhost:8080
```

An HTTP `200` or `302` response indicates that the web server responded.

## 4. Stop the application

From the project directory, stop and remove the containers while preserving the database volume:

```shell
podman-compose down
```

To also delete the database data, use `podman-compose down -v`. This permanently removes the data stored in the Compose volume.
