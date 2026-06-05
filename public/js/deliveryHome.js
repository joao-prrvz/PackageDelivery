
let map = L.map("map").setView([46.2044, 6.1432], 13);
const points = [];
const polyLines = L.polyline([]);
polyLines.addTo(map);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);


const icons = new Map([
    [
        "green", new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    ], 
    [
        "red", new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    ],
    [
        "black", new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    ],
    [
        "blue", new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    ],
]);

const greenIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});
const pkgs = []
/**
 * @param  {...{id: number, latitude: number, longitude: number, routeIndex: number|null}} packages 
 */
function addPackages(...packages) {
    packages.sort((a, b) => a.routeIndex - b.routeIndex);
    let routeIndex = 0;
    for (const package of packages) {
        const coordinates = [package.latitude, package.longitude];
        const marker = L.marker(coordinates, {icon: icons.get("black")});
        marker.addEventListener("click", () => {
            if (package.routeIndex !== null)
                return;
            polyLines.addLatLng(coordinates);
            package.routeIndex = routeIndex;
            marker.options.icon = package.routeIndex == 0 ? icons.get("blue") : icons.get("red");
            marker.removeFrom(map);
            marker.addTo(map);
            if (routeIndex >= pkgs.length - 1)
                modal.show();
            routeIndex++;
        });
        marker.addTo(map);

        pkgs.push(package);
    }
}

modal.addEventListener("close", () => {

});

form.addEventListener("submit", async e => {
    e.preventDefault();
    const response = await fetch("/route", {
        method: "POST",
        body: JSON.stringify({packages: pkgs})
    });
    console.log(await response.text());
});