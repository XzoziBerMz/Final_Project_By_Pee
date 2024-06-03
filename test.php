<div class="form-group" style="margin-bottom: 20px;">
    <label for="price">Price:</label>
    <select class="select-price" id="p_price" name="p_price">
        <option value="ราคาคงที่">ราคาคงที่</option>
        <option value="ต่อรองได้">ต่อรองได้</option>
        <option value="ฟรี">ฟรี</option>
    </select>
    <input type="number" class="input-price" id="fixedPrice" name="fixedPrice" value="">
    <input type="number" class="input-price" id="negotiablePrice" name="negotiablePrice" style="display: none;" value="">
    <input type="text" class="input-price" id="freePrice" name="freePrice" style="display: none;" value="ฟรี" disabled>
    <input type="hidden" id="hiddenFreePrice" name="hiddenFreePrice" value="ฟรี">
</div>

<script>
document.getElementById("p_price").addEventListener("change", function() {
    var selectedValue = this.value;
    if (selectedValue === "ราคาคงที่") {
        document.getElementById("fixedPrice").style.display = "inline-block";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "none";
    } else if (selectedValue === "ต่อรองได้") {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "inline-block";
        document.getElementById("freePrice").style.display = "none";
    } else if (selectedValue === "ฟรี") {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "inline-block";
        document.getElementById("freePrice").value = "ฟรี";
        document.getElementById("hiddenFreePrice").value = "ฟรี";
    } else {
        document.getElementById("fixedPrice").style.display = "none";
        document.getElementById("negotiablePrice").style.display = "none";
        document.getElementById("freePrice").style.display = "none";
    }
});
</script>

