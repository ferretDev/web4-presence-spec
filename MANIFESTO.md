```markdown
# From Pages to Presence

**March 17, 2026 — Shawn McGinnis, FerretDev**

## The Problem

AI agents fetch 3.5mb of HTML to extract
2kb of business data. That is not
intelligence. That is an expensive
workaround for a problem that should
not exist.

Schema.org was built for Google crawlers.
Not for AI agents.

presence.w4 is built for AI agents.

## Why Existing Solutions Fall Short

**Schema.org** — page attached metadata.
Remove the page and the identity disappears.

**JSON-LD** — right format, wrong philosophy.
Always attached to a document context.

**LLMs.txt** — right intent, wrong layer.
Still document attached. Still requires
fetching a page.

**WebMCP** — makes agents better at navigating
the document web. A better scraper is
still a scraper.

## The Model

presence.w4 reclassifies web presence
from the document model to the data
component model.

```
Document model
  Unit:          HTML page
  Consumer:      Human browser
  Machine access: Scraping
  Structure:     Implicit
  Ownership:     Platform

Data component model
  Unit:          .w4 object
  Consumer:      AI agent
  Machine access: Direct
  Structure:     Explicit
  Ownership:     You
```

## The Numbers

```
Fetching business data today:
  Full webpage download: ~3.5mb
  Useful business data:  ~2kb
  Ratio:                 1750:1 overhead

presence.w4:
  File size:    ~2kb
  Useful data:  ~2kb
  Ratio:        1:1
```

## The Agentic Shift

Search was probabilistic.
Presence is deterministic.

A search engine guesses you offer web design.
An AI agent knows you are a `ServiceBlock`.

In the agentic internet, users don't browse.
They prompt.

*"Find me a local designer who takes barter."*

No Google. No crawl. No keyword match.
The agent queries the Presence Vector Space.

Businesses with a .w4 file are queryable.
Businesses without one are invisible.

This is not SEO.
SEO optimizes how humans find pages.
Presence defines how agents understand entities.

The shift:

```
SEO era
  Unit:       Page
  Signal:     Keywords, backlinks
  Discovery:  Search ranking

Presence era
  Unit:       Entity
  Signal:     Attributes, identity
  Discovery:  Agent query
```

Token efficiency matters too.
One .w4 file fits where one webpage won't.
Agents prioritize what they can afford to read.

Be readable. Be queryable. Be present.

## The Standard

A presence.w4 file lives at:

```
yourdomain.com/.well-known/presence.w4
```

or via WordPress REST API:

```
yourdomain.com/wp-json/web4/v1/presence
```

2kb. Structured. Typed. Fresh. Yours.

No page fetch required.
No inference required.
No platform dependency.

## The Invitation

This is v0.1. A stake in the ground.

If you are building for AI agents —
implement presence.w4.

If you are building WordPress sites —
install the free plugin.

If you do structured data work —
extend this spec.

If you see what we see —
contribute to the standard.

Spec: w4spec.dev
Standard: web4presence.org
Plugin: WordPress.org (coming soon)
GitHub: github.com/ferretDev/web4-presence-spec

— Shawn McGinnis
FerretDev, Hinton Alberta Canada
March 17, 2026
```
