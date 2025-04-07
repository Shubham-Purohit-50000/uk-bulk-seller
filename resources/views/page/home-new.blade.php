@extends('layout.app')
@section('title','Home')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    /* Sidebar */
    .sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 900;
        top: 0;
        right: 0;
        background-color: #111;
        color: white;
        overflow-x: hidden;
        transition: width 0.4s ease-in-out;
        padding-top: 60px;
    }

    #main img{
        width: 50px;
    }

    .sidebar .closebtn {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 30px;
        cursor: pointer;
        color: white;
    }
    
    .sidebar .closebtn:hover{
        color: #ca3e2c;
    }

    #mySidebar .product-card{
        padding: 10px;
    }

    #mySidebar .product-card div{
        padding: 15px;
        background-color: #ca3e2c;
    }

    #main{
        margin: 4rem 0;
    }

    #main .card-body{
        padding: 5px;
    }

    #main .card{
        border-radius : 0;
        border: none;
        margin-top: 5px;
    }

    #main .nested-category .card-body:hover{
        background-color: #dfdce4;
    }

    #main .nested-category .card-body{
        background-color: #f3ecfc;
        color: #151515;
    }

    #main .card-body.active {
        background-color: #151515;
        color: #fff;
    }

    #main .card-body.active:hover {
        background-color: #151515;
        color: #fff;
    }

    #main .card-body{
        background-color: #ca3e2c;
        color: #fff;
    }

    #main .card-body .category-item{
        justify-content: space-between;
        display: flex;
    }

    #main .card-body .category-item .category-name{
        margin-left: 1rem;
    }

    #main .card-body .category-item i{
        margin-top: 1rem;
        margin-right: 1rem;
    }

    #mySidebar .card-product .card-product-info .title{
        color: #fff;
    }
</style>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            bring_preloader();
            // Load categories dynamically
            $.ajax({
                url: "/shub-categories",
                type: "GET",
                success: function (data) {
                    let categoryHTML = '';
                    data.forEach(category => {
                        if (!category.parent_id) { // Only show parent categories on top
                            categoryHTML += generateCategoryHTML(category);
                        }
                    });
                    $("#categoryAccordion").html(categoryHTML);
                    remove_preloader();
                }
            });

            // Recursive function to generate categories & subcategories
            function generateCategoryHTML(category) {
                let hasSubcategories = category.subcategories_recursive && category.subcategories_recursive.length > 0;

                let html = `
                    <div class="card">
                        <div class="card-body root-cat" id="heading-${category.id}">
                            <div class="category-item d-flex ${hasSubcategories ? 'has-sub' : 'no-sub'}" data-id="${category.id}">
                                <span>
                                    <img class="category-image" src="storage/${category.image}" alt="img"> 
                                    <span class="category-name">${category.name}</span>
                                </span>
                                ${hasSubcategories ? `<i class="fa fa-angle-right category-icon" data-id="${category.id}"></i>` : ''}
                            </div>
                        </div>
                        ${hasSubcategories ? `<div id="collapse-${category.id}" class="nested-category collapse">${generateSubcategories(category.subcategories_recursive)}</div>` : ''}
                    </div>`;

                return html;
            }

            // Function to generate subcategories recursively
            function generateSubcategories(subcategories) {
                let html = '';
                subcategories.forEach(subcategory => {
                    html += generateCategoryHTML(subcategory);
                });
                return html;
            }

            // Toggle top-level categories (ensuring only one expands at a time)
            $(document).on("click", ".has-sub", function () {
                let categoryId = $(this).data("id");
                let targetCollapse = $("#collapse-" + categoryId);
                let icon = $(this).find(".category-icon");

                // Close other categories except for the clicked one
                $(".nested-category").not(targetCollapse.parents(".nested-category")).collapse('hide');

                // Reset icons for other categories
                $(".category-icon").not(icon).removeClass("fa-angle-down").addClass("fa-angle-right");

                // Toggle clicked category
                if (targetCollapse.hasClass("show")) {
                    targetCollapse.collapse('hide');
                    icon.removeClass("fa-angle-down").addClass("fa-angle-right");
                } else {
                    targetCollapse.collapse('show');
                    icon.removeClass("fa-angle-right").addClass("fa-angle-down");
                }
            });

            // Ensure subcategories do not close their parent category
            $(document).on("click", ".nested-category .has-sub", function (event) {
                event.stopPropagation(); // Stop bubbling up to prevent collapsing parent
            });

            // Handle Bootstrap collapse events for proper icon handling
            $(document).on('show.bs.collapse', '.nested-category', function () {
                let categoryId = $(this).attr("id").replace("collapse-", "");
                $(".category-icon[data-id='" + categoryId + "']").removeClass("fa-angle-right").addClass("fa-angle-down");
            });

            $(document).on('hide.bs.collapse', '.nested-category', function () {
                let categoryId = $(this).attr("id").replace("collapse-", "");
                $(".category-icon[data-id='" + categoryId + "']").removeClass("fa-angle-down").addClass("fa-angle-right");
            });

            // Load products when clicking a subcategory (no further subcategories)
            $(document).on("click", ".no-sub", function () {
                $(".card-body").removeClass("active");
                $(this).closest('.card-body').addClass("active");

                let subcategoryId = $(this).data("id");

                $.ajax({
                    url: `/shub-products/${subcategoryId}`,
                    type: "GET",
                    success: function (response) {
                        $("#product-list").html(response);
                        $(".sidebar").css("width", "100%");
                    }
                });
            });

            // Close sidebar
            $(".closebtn").click(function () {
                $(".sidebar").css("width", "0");
            });
        });
    </script>

    <div class="container">
        <div id="mySidebar" class="sidebar">
            <span class="closebtn">&times;</span>
            <div class="sidebar-content container" id="product-list">
                <h4 class="text-center">Select a Subcategory</h4>
            </div>
        </div>
        <div id="main">
            <div class="accordion" id="categoryAccordion">
                <!-- Categories will load here dynamically -->
            </div>
        </div>
    </div>

<!-- Bootstrap 4 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection