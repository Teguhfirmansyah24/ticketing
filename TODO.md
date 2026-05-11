# TODO - Fix Midtrans (Sandbox) for Ticketing App

- [ ] Update plan: confirm changes limited to Sandbox testing
- [ ] Fix token creation order_id mapping reliability (remove time-based variation or store mapping)
- [ ] Implement minimal Midtrans callback route to update order status in Sandbox environment
- [ ] Remove/disable front-end approval + ticket generation on `/orders/success/{id}`
- [ ] Adjust `/orders/success/{id}` view behavior to reflect pending/approved state
- [ ] Run quick manual test checklist (create order -> pay via Snap -> verify order status/tickets)
