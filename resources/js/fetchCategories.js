document.addEventListener("DOMContentLoaded", () => {
    const subCategoryList = document
        .getElementById("sub-category")
        .querySelector("ul");
    const mainCategoryList = document
        .getElementById("main-category")
        .querySelectorAll(".main-category-item");

    let categoryData = [];

    // Fetch all categories and their subcategories once
    fetch("/api/categories-with-subcategories")
        .then((response) => response.json())
        .then((data) => {
            categoryData = data; // Store the data for later use
        })
        .catch((error) => console.error("Error fetching categories:", error));

    // Add hover functionality for main categories
    mainCategoryList.forEach((item) => {
        item.addEventListener("mouseenter", function () {
            const mainCategoryId = this.getAttribute("data-id");
            const mainCategory = categoryData.find(
                (cat) => cat.id === parseInt(mainCategoryId)
            );

            // Clear previous subcategories
            subCategoryList.innerHTML = "";

            if (!mainCategory || !mainCategory.car_part_types.length) {
                subCategoryList.innerHTML =
                    '<li class="list-group-item">No subcategories available</li>';
                return;
            }

            // Populate subcategories for the hovered main category
            mainCategory.car_part_types.forEach((subcategory) => {
                const subItem = document.createElement("li");
                subItem.classList.add("list-group-item", "sub-category-item");
                subItem.setAttribute("data-id", subcategory.id);

                // Update query parameters for filtering
                const currentParams = new URLSearchParams(
                    window.location.search
                );
                currentParams.set("type_id", subcategory.id);

                subItem.innerHTML = `<a href="${
                    window.location.pathname
                }?${currentParams.toString()}">${subcategory.name}</a>`;
                subCategoryList.appendChild(subItem);
            });
        });
    });
});
