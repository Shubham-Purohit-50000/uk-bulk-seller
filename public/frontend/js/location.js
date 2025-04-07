$(document).ready(function() {
    $("#near_by_store .submit").css('display','none');

    function updateSalesmanLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    let lat = position.coords.latitude;
                    let lon = position.coords.longitude;
                    let csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token

                    $.ajax({
                        url: '/update-location',
                        type: 'POST', // Use POST instead of GET
                        data: {
                            latitude: lat,
                            longitude: lon,
                            _token: csrfToken // Add CSRF token
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.nearby_stores.length > 0) {
                                let storeHtml = "";
                                
                                response.nearby_stores.forEach(store => {
                                    storeHtml += `
                                        <div class="store-box d-flex flex-column align-items-center p-2 border rounded selectable-store" 
                                            data-id="${store.id}" 
                                            onclick="selectStore(${store.id})">
                                            <img src="/frontend/images/store-icon.png" class="store-image" alt="${store.name}" width="80" height="80" style="border-radius:50%">
                                            <p class="mt-2 text-caption">${store.name}</p>
                                        </div>
                                    `;
                                });
            
                                $("#storeContainer").html(storeHtml);

                            } else {
                                console.log("No nearby stores found.");
                            }
                        },
                        error: function () {
                            alert("Error fetching stores.");
                        }
                    });
                },
                function (error) {
                    console.error("Error getting location: ", error);
                    // alert("Error getting location, Please check Internet: ", error);
                }
            );
        }
    }
    if (typeof storeNotSelected !== "undefined" && storeNotSelected) {
        $("#near_by_store").modal("show"); // Open modal if store is not selected
    }
    
    setInterval(updateSalesmanLocation, 60000);

});

// Store Selection Function
function selectStore(storeId) {
    $(".selectable-store").removeClass("selected");
    $(`.selectable-store[data-id='${storeId}']`).addClass("selected");
    $("#selected_store").val(storeId); // Store selected store ID in hidden input
    $("#near_by_store .submit").css('display','block');
}
// code end to auto search nearby stores.




// code to manual search store.------------------------------------------------------------------------------------------------
$(document).ready(function () {
    let typingTimer; // Timer to delay AJAX request
    let doneTypingInterval = 300; // 300ms delay before sending request

    $("#search_store").on("keyup", function () {
        clearTimeout(typingTimer);
        let query = $(this).val().trim();

        if (query.length >= 3) {
            typingTimer = setTimeout(function () {
                $.ajax({
                    url: "/get-stores", // Laravel API endpoint
                    type: "GET",
                    data: { search: query },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        let storeList = $("#store_suggestions");
                        storeList.empty().hide();

                        if (data.length > 0) {
                            data.forEach(store => {
                                storeList.append(
                                    `<li class="list-group-item list-group-item-action store-item" data-id="${store.id}">
                                        ${store.name}
                                    </li>`
                                );
                            });
                            storeList.show();
                        }
                    },
                    error: function () {
                        console.log("Error fetching stores.");
                    }
                });
            }, doneTypingInterval);
        } else {
            $("#store_suggestions").hide();
        }
    });

    // Handle store selection
    $(document).on("click", ".store-item", function () {
        let storeId = $(this).data("id");
        let storeName = $(this).text();

        $("#search_store").val(storeName);
        $("#selected_store").val(storeId);
        $("#store_suggestions").hide();

        // Submit the form
        $(".form-select-business").submit();
    });

    // Hide store suggestions when clicking outside
    $(document).on("click", function (e) {
        if (!$(e.target).closest("#search_store, #store_suggestions").length) {
            $("#store_suggestions").hide();
        }
    });
});
