<style>
    * {
        font-family: "Poppins", sans-serif;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes slideOutUp {
        from {
            opacity: 1;
            transform: translateY(20px);
        }

        to {
            opacity: 0;
            transform: translateY(0);
        }
    }
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }


    .fade-in-right {
        animation: fadeInRight 0.6s ease-out forwards;
    }
    .fade-in-left {
        animation: fadeInLeft 1s ease-out forwards;
    }

    .slide-down {
        animation: slideDown 0.3s ease-in-out;
    }
    .slide-out {
        animation: slideOutUp 0.5s ease-in-out;
    }

    /* Scrollbar for sidebar */
    aside::-webkit-scrollbar {
        width: 8px;
    }

    aside::-webkit-scrollbar-track {
        background: #d1fae5;
        border-radius: 1px;
    }

    aside::-webkit-scrollbar-thumb {
        background: #119d6f;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    aside::-webkit-scrollbar-thumb:hover {
        background: #059669;
    }

    /* Menu transition animations */
    #menuMobile {
        transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        transform: translateX(-100%);
        opacity: 0;
        top: 0;
        /* Ensure it starts from the very top */
        left: 0;
        height: 100%;
    }

    #menuMobile.active {
        transform: translateX(0);
        opacity: 1;
    }

    /* Menu item hover effect */
    .menu-item {
        transition: all 0.2s ease;
    }

    .menu-item:hover {
        transform: translateX(5px);
    }

    /* Hamburger menu animation */
    .hamburger-line {
        transition: all 0.3s ease;
    }

    .menu-open .line-1 {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .menu-open .line-2 {
        opacity: 0;
    }

    .menu-open .line-3 {
        transform: rotate(-45deg) translate(5px, -5px);
    }
</style>