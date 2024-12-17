
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Advanced User Menu</title>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .user-menu {
      position: relative;
      display: inline-block;
    }

    .user-avatar {
      display: flex;
      align-items: center;
      cursor: pointer;
      background-color: #ffffff;
      padding: 10px 20px;
      border-radius: 50px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease;
    }

    .user-avatar:hover {
      background-color: #f1f1f1;
    }

    .user-avatar img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 15px;
      object-fit: cover;
    }

    .username {
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }

    .menu-dropdown {
      position: absolute;
      top: 70px;
      right: 0;
      width: 200px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      list-style: none;
      margin: 0;
      padding: 0;
      transform: scale(0);
      transform-origin: top right;
      transition: transform 0.2s ease;
      overflow: hidden;
    }

    .menu-dropdown.active {
      transform: scale(1);
    }

    .menu-dropdown li {
      border-bottom: 1px solid #f1f1f1;
    }

    .menu-dropdown li:last-child {
      border-bottom: none;
    }

    .menu-dropdown a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      text-decoration: none;
      color: #333;
      font-size: 16px;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .menu-dropdown a:hover {
      background-color: #007bff;
      color: #ffffff;
    }

    .menu-dropdown a .icon {
      font-size: 18px;
      color: #007bff;
      transition: color 0.3s ease;
    }

    .menu-dropdown a:hover .icon {
      color: #ffffff;
    }
  </style>
</head>
<body>
  <div class="user-menu">
    <div class="user-avatar">
      <img src="https://via.placeholder.com/50" alt="User Avatar">
      <span class="username">John Doe</span>
    </div>
    <ul class="menu-dropdown">
      <li><a href="#"><span class="icon">👤</span> Profile</a></li>
      <li><a href="#"><span class="icon">⚙️</span> Settings</a></li>
      <li><a href="#"><span class="icon">🔔</span> Notifications</a></li>
      <li><a href="#"><span class="icon">🚪</span> Logout</a></li>
    </ul>
  </div>

  <script>
    // Toggle dropdown menu
    const userAvatar = document.querySelector('.user-avatar');
    const menuDropdown = document.querySelector('.menu-dropdown');

    userAvatar.addEventListener('click', () => {
      menuDropdown.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
      if (!userAvatar.contains(e.target) && !menuDropdown.contains(e.target)) {
        menuDropdown.classList.remove('active');
      }
    });
  </script>
</body>
</html>
