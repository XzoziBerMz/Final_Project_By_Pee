let minValue = document.getElementById("min-value");
let maxValue = document.getElementById("max-value");
const rangeFill = document.querySelector(".range-fill");
// . คือ class || # คือ id

const inputElements = document.querySelectorAll("input[type='range']");
const searchInput = document.querySelector("input[name='search']");
const typeLinks = document.querySelectorAll("a.list-group-item-action");

// Function to validate range and update the fill color on slider
function validateRange() {
  let minPrice = parseInt(inputElements[0].value);
  let maxPrice = parseInt(inputElements[1].value);

  if (minPrice > maxPrice) {
    let tempValue = maxPrice;
    maxPrice = minPrice;
    minPrice = tempValue;
  }

  // เส้น เขียว
  const minPercentage = ((minPrice - phpMinPrice) / (phpMaxPrice - phpMinPrice)) * 100;
  const maxPercentage = ((maxPrice - phpMinPrice) / (phpMaxPrice - phpMinPrice)) * 100;

  rangeFill.style.left = minPercentage + "%";
  rangeFill.style.width = maxPercentage - minPercentage + "%";

  minValue.innerHTML = minPrice + " บาท";
  maxValue.innerHTML = maxPrice + " บาท";

  fetchProducts(minPrice, maxPrice, searchInput.value, getCurrentTypeId());
}

// Function to fetch and display products based on price range
function fetchProducts(minPrice, maxPrice, search, typeId) {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", `show_product_filter.php?min_price=${minPrice}&max_price=${maxPrice}&search=${encodeURIComponent(search)}&type_id=${typeId}&price_type=${getCurrentPriceType()}`, true);

  xhr.onload = function() {
    if (xhr.status === 200) {
      document.getElementById("product-list").innerHTML = xhr.responseText;
    } else {
      console.error("Failed to fetch products");
    }
  };
  xhr.send();
}

// Function to get the current type ID from URL
function getCurrentTypeId() {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get('type_id') || 0;
}

// Add an event listener to each input element
inputElements.forEach((element) => {
  element.addEventListener("input", validateRange);
});

// Add an event listener to the search input
searchInput.addEventListener("input", validateRange);

function getCurrentPriceType() {
  const selectedPriceType = document.querySelector('input[name="price_type"]:checked');
  return selectedPriceType ? selectedPriceType.value : '';
}


// Add an event listener to each type link
typeLinks.forEach((link) => {
  link.addEventListener("click", (event) => {
    event.preventDefault();
    window.history.pushState(null, "", event.target.href);
    validateRange();
  });
});

// Initial call to validateRange
validateRange();
