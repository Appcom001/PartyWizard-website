const colorContainer = document.getElementById('colorContainer');
const addColorBtn = document.getElementById('addColorBtn');
const colorPalette = document.getElementById('colorPalette');

// Event listener to show/hide color palette
addColorBtn.addEventListener('click', (event) => {
    const rect = addColorBtn.getBoundingClientRect();
    colorPalette.style.top = `${colorPalette.offsetHeight}px`;
    colorPalette.style.left = `${rect.left}px`;
    colorPalette.classList.toggle('hidden');
});

// Function to create a new color item
function createColorItem(color) {
    const colorItem = document.createElement('div');
    colorItem.className = "flex items-center p-2 border border-gray-300 rounded-lg relative";
    
    const colorCircle = document.createElement('div');
    colorCircle.className = "w-10 h-10 rounded-full";
    colorCircle.style.backgroundColor = color;
    
    const addPic = document.createElement('div');
    addPic.className = "flex items-center justify-center w-20 h-10 ml-4 border-2 border-dashed border-gray-300 rounded-lg";
    addPic.innerHTML = '<span class="text-gray-400 text-sm">Add pic</span>';
    
    const removeBtn = document.createElement('button');
    removeBtn.className = "ml-4 p-2 text-gray-500 border border-gray-300 rounded-full hover:bg-gray-200";
    removeBtn.innerHTML = '<span>-</span>';
    removeBtn.addEventListener('click', () => {
        colorContainer.removeChild(colorItem);
    });
    
    colorItem.appendChild(colorCircle);
    colorItem.appendChild(addPic);
    colorItem.appendChild(removeBtn);
    
    return colorItem;
}

// Event listener for color palette
colorPalette.addEventListener('click', (event) => {
    const selectedColor = event.target.getAttribute('data-color');
    
    if (selectedColor) {
        const newColorItem = createColorItem(selectedColor);
        colorContainer.appendChild(newColorItem);
        colorPalette.classList.add('hidden'); 
    }
});



// slider range discount
const slider = document.getElementById('percentageSlider');
const display = document.getElementById('percentageDisplay');
slider.addEventListener('input', function() {
    const value = Math.round(this.value / 5) * 5;
    display.textContent = value + '%';
});