<template>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <router-link to="/" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p> Dashboard </p>
                </router-link>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-cart-plus"></i>
                    <p>
                        Gestion des Utilisateurs<i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <router-link to="utilisateur" href="" class="nav-link ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Utilisateurs</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="add-utilisateur" href="" class="nav-link ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ajouter utilisateur</p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="role" class="nav-link ">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Role</p>
                        </router-link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

</template>
