<div class="d-flex">
    <div class="sidebar">
        <ul class="menu-list">
            @role('admin')
                <li><a href="{{ route('dashboard') }}"><i class="fas fa-users"></i> Users</a></li>
            @endrole
            @role('admin|user')
                <li><a href="#"><i class="fas fa-clipboard"></i> Posts</a></li>
            @endrole
        </ul>
    </div>

    <style>
        .d-flex {
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            overflow-x: hidden;
        }

        .sidebar .menu-list {
            list-style: none;
            padding-left: 0;
        }

        .sidebar .menu-list li {
            padding: 10px 20px;
        }

        .sidebar .menu-list li a {
            text-decoration: none;
            font-size: 16px;
            color: #ffffff;
            display: block;
        }

        .sidebar .menu-list li a:hover {
            background-color: #495057;
            color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            width: calc(100% - 250px);
            height: 100vh;
            overflow-y: auto;
        }
    </style>
</div>
