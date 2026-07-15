# CC4E agent notes

## tsugi (nested checkout)

`tsugi/` is checked out as a **subfolder** of this course tree, but it stays in its **own** git repo ([tsugiproject/tsugi](https://github.com/tsugiproject/tsugi.git)). Commits and PRs for Tsugi belong in that repo, not in `cc4e`. It is still quite common to debug Tsugi from within this working tree (paths under `cc4e/tsugi/`); see `tsugi/AGENTS.md` for Tsugi-specific agent guidance.

## media-util (shared media tooling)

Lecture media tooling (whisper, `media.yaml` bootstrap, compare scripts, YouTube helpers) lives in a **separate** git repo, not in this tree:

- **Repo:** [csev/media-util](https://github.com/csev/media-util.git) (`media-util`)
- **Usual checkout:** a **peer folder** next to this course root, e.g. `../media-util` when this repo is `cc4e` under the same parent (`htdocs/cc4e` ↔ `htdocs/media-util`)

Course wiring: `media.env` sets `MEDIA_UTIL` and prepends `$MEDIA_UTIL/bin` to `PATH`. Source `media.env` from the course root before running those tools. Docs and workflow live in `media-util/README.md`; course-specific bits here are `media.env`, `media.yaml`, `lessons.json`, and `youtube/`.
