<nav>
    <ul class="metismenu" id="menu">
        <!-- Dashboard Link -->
        <li class="<?php if ($page == 'dashboard') {
                        echo 'active';
                    } ?>">
            <a href="dashboard.php">
                <i class="ti-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Employee Section Link -->
        <li class="<?php if ($page == 'employee') {
                        echo 'active';
                    } ?>">
            <a href="employees.php">
                <i class="ti-id-badge"></i>
                <span>Employee Section</span>
            </a>
        </li>

        <!-- Department Section Link -->
        <li class="<?php if ($page == 'department') {
                        echo 'active';
                    } ?>">
            <a href="department.php">
                <i class="fa fa-th-large"></i>
                <span>Department Section</span>
            </a>
        </li>

        <!-- Leave Types Link -->
        <li class="<?php if ($page == 'leave') {
                        echo 'active';
                    } ?>">
            <a href="leave-section.php">
                <i class="fa fa-sign-out"></i>
                <span>Leave Types</span>
            </a>
        </li>

        <!-- Manage Leave Dropdown -->
        <li class="<?php if ($page == 'manage-leave') {
                        echo 'active';
                    } ?>">
            <a href="javascript:void(0)" aria-expanded="true">
                <i class="ti-briefcase"></i>
                <span>Manage Leave</span>
            </a>
            <ul class="collapse">
                <!-- Pending Leave Link -->
                <li>
                    <a href="pending-history.php">
                        <i class="fa fa-spinner"></i>
                        Pending
                    </a>
                </li>
                <!-- Approved Leave Link -->
                <li>
                    <a href="approved-history.php">
                        <i class="fa fa-check"></i>
                        Approved
                    </a>
                </li>
                <!-- Declined Leave Link -->
                <li>
                    <a href="declined-history.php">
                        <i class="fa fa-times-circle"></i>
                        Declined
                    </a>
                </li>
                <!-- Leave History Link -->
                <li>
                    <a href="leave-history.php">
                        <i class="fa fa-history"></i>
                        Leave History
                    </a>
                </li>
            </ul>
        </li>

        <!-- Manage Admin Link -->
        <li class="<?php if ($page == 'manage-admin') {
                        echo 'active';
                    } ?>">
            <a href="manage-admin.php">
                <i class="fa fa-lock"></i>
                <span>Manage Admin</span>
            </a>
        </li>
    </ul>
</nav>