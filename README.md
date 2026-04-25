# presence.w4

**The structured presence standard for AI agent search.**

Schema.org was built for Google.
`presence.w4` is built for AI agents.

AI agents fetch 3.5mb of HTML to extract 2kb of business data. `presence.w4` fixes that.

A structured 2kb identity file at a known endpoint. Direct. Typed. Fresh. Yours.

---

## The problem

AI agents scrape entire webpages to find basic business information. That's 3.5mb to extract 2kb of useful data. Slow. Expensive. Inaccurate.

## The solution

A dedicated structured data endpoint at a known location:

```
yourdomain.com/presence.w4
yourdomain.com/.well-known/presence.w4
```

WordPress fallback:

```
yourdomain.com/wp-json/web4/v1/presence
```

2kb. Typed fields. Known format. No page fetch. No inference. No scraping.

## Minimum viable presence.w4

```json
{
  "meta:schema": "https://web4presence.org/schema/2026-04-25",
  "meta:type": "LocalBusiness",
  "meta:version": "0.2",
  "meta:updated": "2026-04-25T14:00:00Z",
  "meta:language": "en-CA",
  "meta:ttl": 86400,

  "identity:name": "Joe's Plumbing",
  "identity:type": "LocalBusiness",
  "identity:tagline": "Hinton's most trusted plumber",

  "local:city": "Hinton",
  "local:region": "Alberta",
  "local:country": "CA",
  "local:reach:model": "local-only",

  "trust:verified": false,
  "trust:since": "2008",

  "for:agents:context": "Joe's Plumbing is a locally owned emergency plumbing service in Hinton Alberta Canada. Available 24 hours. Serving Hinton and within 80km.",
  "for:agents:keywords": ["plumber", "emergency plumbing", "Hinton"],

  "blocks": [
    {
      "block:type": "ContactBlock",
      "block:phone": "+17805550123",
      "block:cta:label": "Call Now",
      "block:cta:action": "call",
      "block:cta:endpoint": "tel:+17805550123"
    }
  ],

  "actions:primary": {
    "action:type": "call",
    "action:label": "Call Now",
    "action:endpoint": "tel:+17805550123"
  },

  "compat:schema-org": "/schema.json",
  "compat:llms-txt": "/llms.txt"
}
```

## Specification

The full specification lives at **[web4presence.org/spec](https://web4presence.org/spec)** and in this repository:

- **[SPEC-v0.2.md](spec/SPEC-v0.2.md)** — current draft *(April 25, 2026)*
- [SPEC-v0.1.md](spec/SPEC-v0.1.md) — initial draft *(March 17, 2026, superseded)*

## Validate

A live validator is available at **[web4presence.org/validate](https://web4presence.org/validate)**. Paste your `presence.w4` file or point it at your domain.

## WordPress Plugin

A free reference implementation is in `plugin/`. It generates a valid `presence.w4` from existing site data, exposes it at the well-known and REST endpoints, and adds the discovery `<link>` tag automatically.

Coming to WordPress.org. Install and forget.

## Manifesto

The case for `presence.w4` and what it means for the AI-agent web is in [MANIFESTO.md](MANIFESTO.md), and at **[frompagestopresence.org](https://frompagestopresence.org)**.

## Examples

Ready-to-use examples for each `identity:type` are in `examples/`:

- `localbusiness.w4.json`
- `organization.w4.json`
- `service.w4.json`
- `product.w4.json`
- `person.w4.json`
- `article.w4.json`

## Contribute

Issues and pull requests welcome. The specification is intentionally permissive at v0.x — fields, vocabularies, and block types can grow without breaking existing consumers, so suggestions for new domain coverage are encouraged.

For substantial proposals, open an issue first to discuss.

## License

MIT — open forever.

---

*Maintained by [FerretDev](https://ferretdev.com). Editor: [Shawn McGinnis](mailto:smcginnis@ferretdev.com).*
