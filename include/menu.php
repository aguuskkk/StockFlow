        <aside class="menu" id="menu">
            <!-- Logo-->
            <a href="../index.php" class="logo">
                <img src="../assets/img/logo/logo-text.svg" alt="Logo de StockFlow" class="logo-text">
            </a>
            <!-- Menu -->
            <ul class="menu-list">
                <!-- Dashboard -->
                <li class="menu-item">
                    <a href="../views/dashboard.php" class="menu-link">
                        <i class="fa-solid fa-house" style="color: rgb(0, 0, 0);"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] === 'repositor' || $_SESSION['rol'] === 'administrador')): ?>
                    <!-- Inventario -->
                    <li class="menu-item">
                        <a href="../views/inventory.php" class="menu-link">
                            <i class="fa-solid fa-box-open" style="color: rgb(0, 0, 0);"></i>
                            <span>Inventario</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['rol']) && ($_SESSION['rol'] === 'vendedor' || $_SESSION['rol'] === 'administrador')): ?>
                    <!-- Ventas -->
                    <li class="menu-item">
                        <a href="../views/ventas.php" class="menu-link">
                            <i class="fa-solid fa-chart-line" style="color: rgb(0, 0, 0);"></i>
                            <span>Ventas</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador'): ?>
                    <!-- Gastos -->
                    <li class="menu-item">
                        <a href="../views/gastos.php" class="menu-link">
                            <i class="fa-solid fa-receipt" style="color: rgb(0, 0, 0);"></i>
                            <span>Gastos</span>
                        </a>
                    </li>
                    <!-- Reportes -->
                    <li class="menu-item">
                        <a href="../views/reportes.php" class="menu-link">
                            <i class="fa-solid fa-file" style="color: rgb(0, 0, 0);"></i>
                            <span>Reportes</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador'): ?>
                <!-- Usuarios (Solo administradores) -->
                <li class="menu-item">
                    <a href="../views/usuarios.php" class="menu-link">
                        <i class="fa-solid fa-users" style="color: rgb(0, 0, 0);"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <!-- Otras opciones -->
            <div class="menu-options">
                <a href="logout.php" id="menu-btn-logout" class="menu-btn-logout" aria-label="Cerrar sesión" title="Cerrar sesión">
                    <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                </a>
            </div>

            <!-- Boton de cerrar menu solo moblie -->
            <button id="menu-btn-close" class="menu-btn-close" aria-label="Cerrar menu" title="Cerrar menu">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>            
            </button>
        </aside>