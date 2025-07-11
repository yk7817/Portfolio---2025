// ****************************
//           canvas
// ****************************

// background particle validations
const mv = document.getElementById("js-main-visual");
const spacing = 30;
const x = innerWidth / spacing;
const y = innerHeight / spacing;
const particles = [];

// title canvas validations
const canvas = document.createElement("canvas");
canvas.width = innerWidth;
canvas.height = innerHeight;
const ctx = canvas.getContext("2d");
// const texts = [
//   { text: "YK", tx: canvas.width / 2, ty: canvas.height / 2 },
//   { text: "web production", tx: canvas.width / 3, ty: canvas.height / 3 },
//   { text: "portfolio", tx: canvas.width / 3, ty: canvas.height / 4 },
// ];
const text = "{ Y.K }";
const fontsize = 300;
const tb_fontsize = 200;
const sp_fontsize = 100;
const text_borders = [];

const mvCanvas = async () => {
  // create canvas
  const app = new PIXI.Application();
  await app.init({ backgroundAlpha: 0, resizeTo: window });
  app.view.classList.add("c-main-visual__canvas");
  mv.appendChild(app.view);
  app.view.style.touchAction = "auto";
  await title_canvas(app);
};

// create particles
async function particles_create(app) {
  app.stage.eventMode = "static";
  app.stage.hitArea = app.screen;
  for (let i = 0; i < x; i++) {
    for (let j = 0; j < y; j++) {
      const particle = new PIXI.Graphics();
      particle.beginFill(0x252525);
      particle.drawCircle(0, 0, 3);
      particle.endFill();
      particle.x = i * spacing;
      particle.y = j * spacing;
      app.stage.addChild(particle);
      particles.push(particle);
    }
  }
}

// particles mouse action
async function mouse_move_particles(app) {
  app.stage.on("pointermove", (e) => {
    const mouse = e.global;
    particles.forEach((p) => {
      const inRange =
        mouse.x - 100 < p.x &&
        mouse.x + 100 > p.x &&
        mouse.y - 100 < p.y &&
        mouse.y + 100 > p.y;
      if (inRange) {
        // p.tint = 0xffffff;
        p.scale.set(0.8);
      } else {
        // p.tint = 0xffffff;
        p.scale.set(1);
      }
    });
  });
}

async function title_canvas(app) {
  ctx.fillStyle = "#ffffff";
  if (innerWidth <= 550) {
    ctx.font = `${sp_fontsize}px Noto Serif JP, serif`;
  } else if (innerWidth <= 830) {
    ctx.font = `${tb_fontsize}px Noto Serif JP, serif`;
  } else {
    ctx.font = `${fontsize}px Noto Serif JP, serif`;
  }
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";
  ctx.fillText(text, canvas.width / 2, canvas.height / 2);

  // テキストデータのピクセル情報を取得
  const text_data = ctx.getImageData(0, 0, canvas.width, canvas.height);
  const text_pixels = text_data.data;
  const targets = [];

  for (let y = 0; y < canvas.height; y += 3) {
    for (let x = 0; x < canvas.width; x += 6) {
      const start_r = (y * canvas.width + x) * 4;
      if (text_pixels[start_r + 3] > 128) {
        targets.push({ x: x + canvas.width / 2, y: y + canvas.height });
      }
    }
  }

  for (let i = 0; i < targets.length; i++) {
    const g = new PIXI.Graphics();
    g.beginFill(0x848484);
    g.drawRect(targets[i].x / 2, targets[i].y / 3, 5, 1);
    g.endFill();
    g._origin = { x: targets[i].x / 2, y: targets[i].y / 3 };
    app.stage.addChild(g);
    text_borders.push(g);
  }

  app.stage.interactive = true;
  app.stage.on("pointermove", (e) => {
    const mouse = e.global;
    text_borders.forEach((tb) => {
      let dx = mouse.x - tb._origin.x;
      let dy = mouse.y - tb._origin.y;
      let distance = Math.sqrt(dx * dx + dy * dy);
      if (distance < 5) {
        gsap.to(tb, {
          groupColor: 15018496,
          //   x: (tb.x += 15),
          width: 6,
          duration: 0.5,
          ease: "power2.out",
        });
      } else {
        gsap.to(tb, {
          groupColor: 16777215,
          //   x: (tb.x = 0),
          width: 5,
          duration: 0.5,
          ease: "power2.out",
        });
      }
    });
  });
}

window.onload = mvCanvas;
let current_width = window.innerWidth;
window.addEventListener("resize", () => {
  if (current_width == window.innerWidth) {
    return;
  }
  window.location.reload();
});

//-------------------------
// gsap setting
//-------------------------
const item_wrap = document.getElementById("js-work");
const items = Array.from(item_wrap.children);

items.forEach((item) => {
  const clone = item.cloneNode(true);
  item_wrap.appendChild(clone);
});

const wrapWidth = item_wrap.scrollWidth / 2;

gsap.to(item_wrap, {
  x: `-=${wrapWidth}`,
  duration: 20,
  ease: "none",
  repeat: -1,
  modifiers: {
    x: gsap.utils.unitize((x) => parseFloat(x) % wrapWidth),
  },
});

//-------------------------
// section scroll
//-------------------------
const menu_item = document.querySelectorAll("#js-header-menu > li > a");
menu_item.forEach((value) => {
  const item_id = value.getAttribute("href");
  value.setAttribute("data-scroll", item_id);
});

document.querySelectorAll("[data-scroll]").forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    const target_id = link.getAttribute("data-scroll");
    const target = document.querySelector(target_id);
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
      });
    }
  });
});

//-------------------------
// reverce top scroll
//-------------------------

const top_reverse_button = document.getElementById("js-top-reverse");
window.addEventListener("scroll", (e) => {
  const button_show_height = mv.clientHeight;
  if (button_show_height < window.scrollY) {
    top_reverse_button.classList.add("is-show");
    top_reverse_button.addEventListener("click", (e) => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    });
  } else {
    top_reverse_button.classList.remove("is-show");
  }
});
