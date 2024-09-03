<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Recommender</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .course { border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Course Recommender</h1>

    <!-- Formulario para Buscar Cursos -->
    <form method="get" action="">
        <label for="query">Buscar Cursos:</label>
        <input type="text" id="query" name="query" required>
        <button type="submit">Buscar</button>
    </form>

    <!-- Listar Todos los Cursos -->
    <h2>Todos los Cursos</h2>
    <div id="all-courses">
        <script>
            async function fetchData(url) {
                const response = await fetch(url);
                if (!response.ok) {
                    document.getElementById('all-courses').innerHTML = `<p>Error fetching data from API. HTTP Status Code: ${response.status}</p>`;
                    return [];
                }
                return await response.json();
            }

            const baseUrl = "http://localhost:5143/api";

            async function loadAllCourses() {
                const allCourses = await fetchData(`${baseUrl}/course?limit=10`);
                const allCoursesDiv = document.getElementById('all-courses');
                if (allCourses.length > 0) {
                    allCourses.forEach(course => {
                        const courseDiv = document.createElement('div');
                        courseDiv.className = 'course';
                        courseDiv.innerHTML = `<h3>${course.course_name}</h3><p>${course.course_description}</p><a href="?recommendations=${course.id}">Ver Recomendaciones</a>`;
                        allCoursesDiv.appendChild(courseDiv);
                    });
                } else {
                    allCoursesDiv.innerHTML = "<p>No se encontraron cursos.</p>";
                }
            }

            loadAllCourses();
        </script>
    </div>

    <!-- Mostrar Recomendaciones de un Curso Específico -->
    <div id="recommendations">
        <script>
            async function loadRecommendations(courseId) {
                const recommendations = await fetchData(`${baseUrl}/course/${courseId}`);
                const recommendationsDiv = document.getElementById('recommendations');
                recommendationsDiv.innerHTML = `<h2>Recomendaciones para el Curso ID: ${courseId}</h2>`;
                if (recommendations.length > 0) {
                    recommendations.forEach(course => {
                        const courseDiv = document.createElement('div');
                        courseDiv.className = 'course';
                        courseDiv.innerHTML = `<h3>${course.course_name}</h3><p>${course.course_description}</p>`;
                        recommendationsDiv.appendChild(courseDiv);
                    });
                } else {
                    recommendationsDiv.innerHTML += "<p>No se encontraron recomendaciones.</p>";
                }
            }

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('recommendations')) {
                loadRecommendations(urlParams.get('recommendations'));
            }
        </script>
    </div>

    <!-- Mostrar Resultados de Búsqueda -->
    <div id="search-results">
        <script>
            async function loadSearchResults(query) {
                const searchResults = await fetchData(`${baseUrl}/search?query=${encodeURIComponent(query)}&limit=5`);
                const searchResultsDiv = document.getElementById('search-results');
                searchResultsDiv.innerHTML = `<h2>Resultados de Búsqueda para: ${query}</h2>`;
                if (searchResults.length > 0) {
                    searchResults.forEach(course => {
                        const courseDiv = document.createElement('div');
                        courseDiv.className = 'course';
                        courseDiv.innerHTML = `<h3>${course.course_name}</h3><p>${course.course_description}</p>`;
                        searchResultsDiv.appendChild(courseDiv);
                    });
                } else {
                    searchResultsDiv.innerHTML += "<p>No se encontraron resultados.</p>";
                }
            }

            if (urlParams.has('query')) {
                loadSearchResults(urlParams.get('query'));
            }
        </script>
    </div>
</body>
</html>
