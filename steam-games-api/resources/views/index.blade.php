<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam Games API | Management Console</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0b0e14;
            --card-bg: #1b2838; /* Classic Steam Blue-Grey */
            --accent-color: #66c0f4; /* Steam Blue */
            --accent-gradient: linear-gradient(90deg, #06b7ff 0%, #2a475e 100%);
            --text-primary: #f8fafc;
            --text-secondary: #8f98a0;
            --danger: #ff4b4b;
            --success: #4caf50;
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-primary); min-height: 100vh; line-height: 1.6; }

        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }

        /* Utility Classes */
        .glass { background: var(--glass-bg); backdrop-filter: blur(10px); border: 1px solid var(--glass-border); border-radius: 12px; }
        .hidden { display: none !important; }

        /* Header */
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .logo { font-size: 1.8rem; font-weight: 700; color: white; letter-spacing: 2px; }
        .logo span { color: var(--accent-color); }

        /* Buttons */
        .btn { padding: 0.7rem 1.5rem; border-radius: 4px; border: none; cursor: pointer; font-weight: 600; transition: 0.3s; color: white; }
        .btn-primary { background: #214b6b; border: 1px solid #3d6c8d; }
        .btn-primary:hover { background: #3d6c8d; }
        .btn-add { background: var(--accent-gradient); box-shadow: 0 4px 15px rgba(102, 192, 244, 0.2); }
        .btn-danger { background: rgba(255, 75, 75, 0.1); color: var(--danger); border: 1px solid rgba(255, 75, 75, 0.2); }
        .btn-danger:hover { background: var(--danger); color: white; }

        /* Hero */
        .hero { 
            height: 350px; border-radius: 12px; overflow: hidden; margin-bottom: 2rem;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('/images/hero.png');
            background-size: cover; background-position: center;
            display: flex; flex-direction: column; justify-content: flex-end; padding: 3rem;
        }
        .hero h1 { font-size: 3rem; margin-bottom: 0.5rem; }
        .hero p { color: var(--text-secondary); max-width: 600px; margin-bottom: 1.5rem; }

        /* Filters */
        .filters { display: flex; gap: 0.8rem; margin-bottom: 2rem; overflow-x: auto; padding-bottom: 0.5rem; }
        .filter-chip { padding: 0.4rem 1rem; border-radius: 4px; background: #171a21; border: 1px solid transparent; cursor: pointer; transition: 0.3s; color: var(--text-secondary); }
        .filter-chip.active { background: #2a475e; color: white; border-color: var(--accent-color); }

        /* Game Grid */
        .game-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .game-card { background: #16202d; padding: 0; position: relative; display: flex; flex-direction: column; }
        .card-img { height: 160px; background: #000; border-radius: 12px 12px 0 0; }
        .card-body { padding: 1.2rem; flex-grow: 1; }
        .card-title { font-size: 1.2rem; margin-bottom: 0.5rem; }
        .card-desc { color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 1rem; height: 3.6rem; overflow: hidden; }
        .card-footer { padding: 1rem 1.2rem; border-top: 1px solid var(--glass-border); display: flex; justify-content: space-between; }

        .tag { font-size: 0.7rem; padding: 0.2rem 0.5rem; background: rgba(102, 192, 244, 0.1); color: var(--accent-color); border-radius: 3px; margin-right: 0.4rem; }

        /* Modals */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); display: flex; justify-content: center; align-items: center; z-index: 2000; }
        .modal { background: #1b2838; width: 90%; max-width: 500px; padding: 2rem; border-radius: 8px; border: 1px solid #3d6c8d; }
        .modal h2 { margin-bottom: 1.5rem; color: var(--accent-color); }

        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; font-size: 0.9rem; color: var(--text-secondary); }
        .form-group input, .form-group textarea, .form-group select { 
            width: 100%; padding: 0.8rem; background: #0b0e14; border: 1px solid #2a475e; color: white; border-radius: 4px; outline: none; 
        }
        .form-group input:focus { border-color: var(--accent-color); }

        /* Auth */
        #auth-view { height: 100vh; display: flex; justify-content: center; align-items: center; }

        /* Loader */
        .loader { width: 30px; height: 30px; border: 3px solid var(--accent-color); border-bottom-color: transparent; border-radius: 50%; display: inline-block; animation: rot 1s linear infinite; }
        @keyframes rot { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

    <!-- Auth View -->
    <div id="auth-view" class="container">
        <div class="modal">
            <h2 style="text-align: center" id="auth-title">STEAM<span>API</span></h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 2rem" id="auth-subtitle">Sign in to manage your collection</p>
            
            <div id="auth-error" class="hidden" style="color: var(--danger); text-align: center; margin-bottom: 1rem">Action failed. Check your inputs.</div>
            
            <div id="register-fields" class="hidden">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="reg-name" placeholder="John Doe">
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" id="email" value="pete@abc.com">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" value="qwerty1234">
            </div>

            <div id="register-confirm-fields" class="hidden">
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" id="password_confirmation">
                </div>
            </div>

            <button class="btn btn-add" style="width: 100%" id="auth-submit-btn" onclick="handleAuth()">Login</button>
            
            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem">
                <span id="auth-toggle-text">Don't have an account?</span>
                <a href="#" id="auth-toggle-link" onclick="toggleAuthMode()" style="color: var(--accent-color); text-decoration: none">Register</a>
            </p>
        </div>
    </div>

    <!-- Main Dashboard -->
    <div id="dashboard" class="container hidden">
        <header>
            <div class="logo">STEAM<span>API</span></div>
            <div style="display: flex; gap: 1rem; align-items: center">
                <span id="user-display" style="color: var(--text-secondary)"></span>
                <button class="btn btn-add" onclick="openModal('create')">+ Add New Game</button>
                <button class="btn btn-danger" onclick="logout()">Logout</button>
            </div>
        </header>

        <section class="hero" id="featured-hero">
            <div id="hero-content">
                <div class="tag">TOP RATED</div>
                <h1>Welcome to Steam API</h1>
                <p>Start managing your library of games and genres with our robust RESTful management system.</p>
            </div>
        </section>

        <div class="filters" id="genre-filters">
            <div class="filter-chip active" onclick="setFilter('all', this)">All Games</div>
        </div>

        <div class="game-grid" id="game-grid">
            <!-- Games load here -->
        </div>
    </div>

    <!-- CRUD Modal -->
    <div id="crud-modal" class="modal-overlay hidden">
        <div class="modal">
            <h2 id="modal-title">Add New Game</h2>
            <input type="hidden" id="edit-id">
            <div class="form-group">
                <label>Game Title</label>
                <input type="text" id="game-title">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea id="game-desc" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Genres (Hold Ctrl to select multiple)</label>
                <select id="game-genres" multiple style="height: 100px"></select>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end">
                <button class="btn btn-primary" onclick="closeModal()">Cancel</button>
                <button class="btn btn-add" id="save-btn" onclick="saveGame()">Save Game</button>
            </div>
        </div>
    </div>

    <script>
        const API_URL = '/api';
        let token = localStorage.getItem('token');
        let genresList = [];

        // App Initialization
        if (token) {
            initDashboard();
        }

        let isLoginMode = true;

        async function handleAuth() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMsg = document.getElementById('auth-error');
            
            let payload = { email, password };
            let endpoint = `${API_URL}/login`;

            if (!isLoginMode) {
                payload.name = document.getElementById('reg-name').value;
                payload.password_confirmation = document.getElementById('password_confirmation').value;
                endpoint = `${API_URL}/register`;
            }

            const res = await fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (res.ok) {
                const data = await res.json();
                token = data.token;
                localStorage.setItem('token', token);
                localStorage.setItem('user', data.user.name);
                initDashboard();
            } else {
                errorMsg.classList.remove('hidden');
            }
        }

        function toggleAuthMode() {
            isLoginMode = !isLoginMode;
            const title = document.getElementById('auth-title');
            const subtitle = document.getElementById('auth-subtitle');
            const submitBtn = document.getElementById('auth-submit-btn');
            const toggleText = document.getElementById('auth-toggle-text');
            const toggleLink = document.getElementById('auth-toggle-link');
            const regFields = document.getElementById('register-fields');
            const regConfirmFields = document.getElementById('register-confirm-fields');

            if (isLoginMode) {
                title.innerHTML = 'STEAM<span>API</span>';
                subtitle.textContent = 'Sign in to manage your collection';
                submitBtn.textContent = 'Login';
                toggleText.textContent = "Don't have an account?";
                toggleLink.textContent = 'Register';
                regFields.classList.add('hidden');
                regConfirmFields.classList.add('hidden');
            } else {
                title.textContent = 'Create Account';
                subtitle.textContent = 'Join the Steam API community';
                submitBtn.textContent = 'Register';
                toggleText.textContent = "Already have an account?";
                toggleLink.textContent = 'Login';
                regFields.classList.remove('hidden');
                regConfirmFields.classList.remove('hidden');
            }
        }

        function logout() {
            localStorage.clear();
            location.reload();
        }

        function initDashboard() {
            document.getElementById('auth-view').classList.add('hidden');
            document.getElementById('dashboard').classList.remove('hidden');
            document.getElementById('user-display').textContent = localStorage.getItem('user');
            loadGenres();
            loadGames();
        }

        async function loadGenres() {
            // In a real app, we'd have a separate /genres endpoint. 
            // Here we'll just extract them or use a hardcoded list if needed.
            // For the lab, let's assume we can get them from the games list or seeders.
            const res = await fetch(`${API_URL}/games`, { headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
            const { data } = await res.json();
            
            const genreMap = new Map();
            data.forEach(game => game.genres.forEach(g => genreMap.set(g.id, g.name)));
            
            const filterContainer = document.getElementById('genre-filters');
            const selectContainer = document.getElementById('game-genres');
            
            filterContainer.innerHTML = '<div class="filter-chip active" onclick="setFilter(\'all\', this)">All Games</div>';
            selectContainer.innerHTML = '';

            genreMap.forEach((name, id) => {
                // Filter chips
                const chip = document.createElement('div');
                chip.className = 'filter-chip';
                chip.textContent = name;
                chip.onclick = (e) => setFilter(id, chip);
                filterContainer.appendChild(chip);

                // Modal select options
                const opt = document.createElement('option');
                opt.value = id;
                opt.textContent = name;
                selectContainer.appendChild(opt);
                
                genresList.push({id, name});
            });
        }

        async function loadGames(genreId = null) {
            const grid = document.getElementById('game-grid');
            grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center"><span class="loader"></span></div>';
            
            let url = `${API_URL}/games`;
            if (genreId && genreId !== 'all') url += `?genre_id=${genreId}`;

            const res = await fetch(url, { headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
            const { data } = await res.json();

            grid.innerHTML = '';
            data.forEach(game => {
                const card = document.createElement('div');
                card.className = 'game-card glass';
                card.innerHTML = `
                    <div class="card-body">
                        <div class="card-title">${game.title}</div>
                        <div class="card-desc">${game.description || 'No description provided.'}</div>
                        <div>${game.genres.map(g => `<span class="tag">${g.name}</span>`).join('')}</div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary" onclick="editGame(${JSON.stringify(game).replace(/"/g, '&quot;')})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteGame(${game.id})">Delete</button>
                    </div>
                `;
                grid.appendChild(card);
            });
            
            // Update Hero if games exist
            if(data.length > 0 && !genreId) updateHero(data[0]);
        }

        function updateHero(game) {
            const heroContent = document.getElementById('hero-content');
            heroContent.innerHTML = `
                <div class="tag">FEATURED GAME</div>
                <h1>${game.title}</h1>
                <p>${game.description}</p>
                <button class="btn btn-add">Play Now</button>
            `;
        }

        function setFilter(id, el) {
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            loadGames(id);
        }

        // CRUD Logic
        function openModal(mode, game = null) {
            document.getElementById('crud-modal').classList.remove('hidden');
            const title = document.getElementById('modal-title');
            if (mode === 'create') {
                title.textContent = 'Add New Game';
                document.getElementById('edit-id').value = '';
                document.getElementById('game-title').value = '';
                document.getElementById('game-desc').value = '';
                document.getElementById('game-genres').value = '';
            }
        }

        function editGame(game) {
            openModal('edit');
            document.getElementById('modal-title').textContent = 'Edit Game';
            document.getElementById('edit-id').value = game.id;
            document.getElementById('game-title').value = game.title;
            document.getElementById('game-desc').value = game.description;
            
            // Select genres
            const select = document.getElementById('game-genres');
            const ids = game.genres.map(g => g.id.toString());
            Array.from(select.options).forEach(opt => opt.selected = ids.includes(opt.value));
        }

        async function saveGame() {
            const id = document.getElementById('edit-id').value;
            const title = document.getElementById('game-title').value;
            const description = document.getElementById('game-desc').value;
            const genres = Array.from(document.getElementById('game-genres').selectedOptions).map(o => parseInt(o.value));

            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/games/${id}` : `${API_URL}/games`;

            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' },
                body: JSON.stringify({ title, description, genres })
            });

            if (res.ok) {
                closeModal();
                loadGames();
            } else {
                alert('Validation error. Make sure title is unique.');
            }
        }

        async function deleteGame(id) {
            if (!confirm('Are you sure?')) return;
            const res = await fetch(`${API_URL}/games/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            if (res.ok) loadGames();
        }

        function closeModal() { document.getElementById('crud-modal').classList.add('hidden'); }
    </script>
</body>
</html>
