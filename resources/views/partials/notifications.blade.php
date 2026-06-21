@if(auth()->check() && auth()->user()->type === 'admin')
<style>
    /* ===== Notification dropdown styling ===== */
    .notifications-menu .dropdown-menu {
        width: 340px;
        padding: 0;
        border: none;
        box-shadow: 0 6px 24px rgba(0,0,0,.15);
        border-radius: 6px;
        overflow: hidden;
    }
    .notifications-menu .dropdown-menu > .notif-head {
        background: #3c8dbc;
        color: #fff;
        padding: 12px 15px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .notifications-menu .notif-head small {
        font-weight: 400;
        opacity: .85;
        font-size: 12px;
    }
    .notif-scroll {
        max-height: 320px;
        overflow-y: auto;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .notif-scroll li.notif-item {
        position: relative;
        border-bottom: 1px solid #f0f0f0;
        transition: background .15s ease;
    }
    .notif-scroll li.notif-item:hover {
        background: #f7fbff;
    }
    .notif-scroll li.notif-item.unread {
        background: #eef6ff;
    }
    .notif-scroll li.notif-item.unread:hover {
        background: #e2f0ff;
    }
    .notif-scroll li.notif-item .notif-link {
        display: block;
        padding: 12px 38px 12px 14px;
        color: #333 !important;
        white-space: normal;
        line-height: 1.4;
    }
    .notif-scroll li.notif-item .notif-link .notif-msg {
        font-size: 13px;
        font-weight: 500;
    }
    .notif-scroll li.notif-item .notif-link .notif-time {
        font-size: 11px;
        color: #999;
        display: block;
        margin-top: 3px;
    }
    .notif-scroll li.notif-item .notif-avatar {
        display: inline-block;
        width: 30px; height: 30px;
        line-height: 30px;
        text-align: center;
        border-radius: 50%;
        background: #3c8dbc;
        color: #fff;
        font-size: 14px;
        margin-right: 8px;
        vertical-align: middle;
    }
    .notif-scroll li.notif-item .notif-close {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        width: 22px; height: 22px;
        line-height: 22px;
        text-align: center;
        border-radius: 50%;
        color: #bbb;
        font-size: 12px;
        transition: all .15s ease;
        z-index: 5;
    }
    .notif-scroll li.notif-item .notif-close:hover {
        background: #dd4b39;
        color: #fff;
    }
    .notif-empty {
        padding: 25px 15px;
        text-align: center;
        color: #999;
        font-size: 13px;
    }
    .notif-footer {
        display: flex;
        border-top: 1px solid #eee;
    }
    .notif-footer a {
        flex: 1;
        text-align: center;
        padding: 10px;
        font-size: 12px;
        font-weight: 600;
        color: #3c8dbc !important;
        transition: background .15s ease;
    }
    .notif-footer a:hover { background: #f4f4f4; }
    .notif-footer a.clear { color: #dd4b39 !important; }
    .notifications-menu .notif-bell { position: relative; }
    .notifications-menu .label-warning {
        position: absolute;
        top: 8px; right: 4px;
        font-size: 10px;
        padding: 2px 5px;
        border-radius: 10px;
    }
    /* ===== Blink / pulse jab naya notification aaye ===== */
    @keyframes notifPulse {
        0%   { transform: scale(1);   }
        50%  { transform: scale(1.35); }
        100% { transform: scale(1);   }
    }
    @keyframes notifShake {
        0%, 100% { transform: rotate(0deg); }
        20% { transform: rotate(-15deg); }
        40% { transform: rotate(12deg); }
        60% { transform: rotate(-8deg); }
        80% { transform: rotate(5deg); }
    }
    .notifications-menu .notif-bell.has-new .fa-bell-o {
        color: #f39c12;
        animation: notifShake 0.8s ease-in-out infinite;
        transform-origin: top center;
    }
    .notifications-menu .label-warning.blink {
        animation: notifPulse 1s ease-in-out infinite;
    }
    .notif-dot {
        position: absolute;
        top: 6px; right: 2px;
        width: 9px; height: 9px;
        background: #dd4b39;
        border-radius: 50%;
        border: 2px solid #fff;
        display: none;
    }
    .notif-dot.show {
        display: block;
        animation: notifPulse 1s ease-in-out infinite;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    const bellLi = document.createElement('li');
    bellLi.className = 'dropdown notifications-menu';
    bellLi.innerHTML = `
        <a href="#" class="dropdown-toggle notif-bell" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="notif-dot" id="notif-dot"></span>
            <span class="label label-warning" id="notif-count" style="display:none;">0</span>
        </a>
        <ul class="dropdown-menu">
            <li class="notif-head">
                <span>Notifications</span>
                <small id="notif-head-count">0 new</small>
            </li>
            <li>
                <ul class="notif-scroll" id="notif-list"></ul>
            </li>
            <li class="notif-footer">
                <a href="#" id="notif-mark-all">Mark all as read</a>
                <a href="#" id="notif-clear-all" class="clear">Clear all</a>
            </li>
        </ul>
    `;

    const navUl = document.querySelector('.navbar-custom-menu .nav.navbar-nav');
    if (navUl) navUl.insertBefore(bellLi, navUl.firstChild);

    document.getElementById('notif-mark-all').addEventListener('click', function(e){
        e.preventDefault(); markAllRead();
    });
    document.getElementById('notif-clear-all').addEventListener('click', function(e){
        e.preventDefault(); clearAll();
    });
     bellLi.querySelector('.notif-bell').addEventListener('click', function () {
        bellLi.querySelector('.notif-bell').classList.remove('has-new');
        const badge = document.getElementById('notif-count');
        if (badge) badge.classList.remove('blink');
    });
    loadNotifications();
    setInterval(loadNotifications, 15000);
});

function csrf() {
    const tag = document.querySelector('meta[name="csrf-token"]');
    return tag ? tag.content : '{{ csrf_token() }}';
}

let lastNotifCount = null; 

function loadNotifications() {
    fetch("{{ route('admin.notifications') }}")
        .then(res => res.json())
        .then(data => {
            const badge   = document.getElementById('notif-count');
            const headCnt = document.getElementById('notif-head-count');
            const list    = document.getElementById('notif-list');
            const bell    = document.querySelector('.notif-bell');
            const dot     = document.getElementById('notif-dot');
            if (!badge) return;

            if (lastNotifCount !== null && data.count > lastNotifCount) {
                triggerBlink(bell, badge, dot);
                playBeep(); 
            }
            lastNotifCount = data.count;

            if (data.count > 0) {
                badge.style.display = 'inline-block';
                badge.textContent = data.count;
                if (dot) dot.classList.add('show');
            } else {
                badge.style.display = 'none';
                if (dot) dot.classList.remove('show');
                stopBlink(bell, badge, dot);
            }
            headCnt.textContent = data.count + ' new';

            if (!data.notifications.length) {
                list.innerHTML = '<li class="notif-empty"><i class="fa fa-bell-slash-o"></i><br>No notifications yet</li>';
                return;
            }

            list.innerHTML = data.notifications.map(n => `
                <li class="notif-item ${n.is_read ? '' : 'unread'}">
                    <a href="#" class="notif-link" onclick="openNotif(${n.id}, '${n.link}'); return false;">
                        <span class="notif-avatar"><i class="fa fa-user"></i></span>
                        <span class="notif-msg">${n.message}</span>
                        <span class="notif-time">${formatTime(n.created_at)}</span>
                    </a>
                    <a href="#" class="notif-close" title="Delete"
                       onclick="deleteNotif(${n.id}); return false;">
                        <i class="fa fa-times"></i>
                    </a>
                </li>
            `).join('');
        })
        .catch(err => console.log('Notif error:', err));
}

function triggerBlink(bell, badge, dot) {
    if (bell)  bell.classList.add('has-new');
    if (badge) badge.classList.add('blink');
    if (dot)   dot.classList.add('show');
    setTimeout(() => {
        if (bell) bell.classList.remove('has-new');
    }, 8000);
}

function stopBlink(bell, badge, dot) {
    if (bell)  bell.classList.remove('has-new');
    if (badge) badge.classList.remove('blink');
}

// Chhoti si beep sound (optional) - browser allow kare to bajegi
function playBeep() {
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const o = ctx.createOscillator();
        const g = ctx.createGain();
        o.connect(g); g.connect(ctx.destination);
        o.type = 'sine';
        o.frequency.value = 700;
        g.gain.setValueAtTime(0.1, ctx.currentTime);
        o.start();
        g.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.3);
        o.stop(ctx.currentTime + 0.3);
    } catch (e) {}
}

function formatTime(dt) {
    const d = new Date(dt);
    return d.toLocaleDateString() + ' ' + d.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
}

// Click → read karo phir us user ke page pe jao
function openNotif(id, link) {
    fetch(`{{ url('admin/notifications') }}/${id}/read`, {
        method: 'POST', headers: { 'X-CSRF-TOKEN': csrf() }
    }).then(() => {
        window.location.href = link;
    }).catch(() => {
        window.location.href = link; // error aaye tab bhi navigate karo
    });
}

function markAllRead() {
    fetch("{{ route('admin.notifications.readAll') }}", {
        method: 'POST', headers: { 'X-CSRF-TOKEN': csrf() }
    }).then(() => loadNotifications());
}
function deleteNotif(id) {
    fetch(`{{ url('admin/notifications') }}/${id}`, {
        method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf() }
    }).then(() => loadNotifications());
}
function clearAll() {
    if (!confirm('Clear all notifications?')) return;
    fetch("{{ route('admin.notifications.clearAll') }}", {
        method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf() }
    }).then(() => loadNotifications());
}
</script>
@endif