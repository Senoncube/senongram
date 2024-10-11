class ContextMenu {
    constructor({ target = null, menuItems = [], mode = "dark" }) {
        this.target = target;
        this.menuItems = menuItems;
        this.mode = mode;
        this.targetNode = this.getTargetNode();
        this.menuItemsNode = this.getMenuItemsNode();
        this.isOpened = false;
    }

    getTargetNode() {
        const nodes = document.querySelectorAll(this.target);

        return nodes;
    }

    getMenuItemsNode() {
        const nodes = [];

        this.menuItems.forEach((data, index) => {
            const item = this.createItemMarkup(data);
            item.firstChild.setAttribute(
                "style",
                `animation-delay: ${index * 0.08}s`
            );
            nodes.push(item);
        });

        return nodes;
    }

    createItemMarkup(data) {
        const button = document.createElement("BUTTON");
        const item = document.createElement("LI");

        button.innerHTML = data.content;
        button.classList.add("contextMenu-button");
        item.classList.add("contextMenu-item");

        if (data.divider) item.setAttribute("data-divider", data.divider);
        item.appendChild(button);

        if (data.events && data.events.length !== 0) {
            Object.entries(data.events).forEach((event) => {
                const [key, value] = event;
                button.addEventListener(key, value);
            });
        }

        return item;
    }

    renderMenu() {
        const menuContainer = document.createElement("UL");

        menuContainer.classList.add("contextMenu");
        menuContainer.setAttribute("data-theme", this.mode);

        this.menuItemsNode.forEach((item) => menuContainer.appendChild(item));

        return menuContainer;
    }

    closeMenu(menu) {
        if (this.isOpened) {
            this.isOpened = false;
            menu.remove();
        }
    }

    init() {
        this.contextMenu = this.renderMenu();
        document.addEventListener("click", () => this.closeMenu(this.contextMenu));
        window.addEventListener("blur", () => this.closeMenu(this.contextMenu));
        document.addEventListener("contextmenu", (e) => {
            let fl = false;
            this.targetNode.forEach((target) => {

                if (target.contains(e.target)) {
                    fl = true;
                }
            });
            if (!fl)
                this.contextMenu.remove();
        });

        for (let target of this.targetNode) {
            this.addContextMenu(target, this.contextMenu);
        }
    }

    update() {
        this.targetNode = this.getTargetNode();
        for (let target of this.targetNode) {
            this.addContextMenu(target, this.contextMenu);
        }
    }

    addContextMenu(target, contextMenu) {
        target.addEventListener("contextmenu", (e) => {
            this.currentTarget = target;
            e.preventDefault();
            this.isOpened = true;

            const { clientX, clientY } = e;
            document.body.appendChild(contextMenu);

            const positionY =
                clientY + contextMenu.scrollHeight >= window.innerHeight
                    ? window.innerHeight - contextMenu.scrollHeight - 20
                    : clientY;
            const positionX =
                clientX + contextMenu.scrollWidth >= window.innerWidth
                    ? window.innerWidth - contextMenu.scrollWidth - 20
                    : clientX;

            contextMenu.setAttribute(
                "style",
                `--width: ${contextMenu.scrollWidth}px;
          --height: ${contextMenu.scrollHeight}px;
          --top: ${positionY}px;
          --left: ${positionX}px;`
            );
        });
    }
}

const copyIcon = `<svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2.5" style="margin-right: 7px" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>`;

const editIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" style="margin-right: 7px; position: relative; top: -1px" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" className="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>`

const deleteIcon = `<svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2.5" fill="none" style="margin-right: 7px" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>`;
