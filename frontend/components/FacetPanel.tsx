"use client";
import { ReactNode } from "react";

export default function FacetPanel({ title, children }: { title: string; children: ReactNode }) {
  return (
    <section className="mb-4">
      <h2 className="mb-2 text-lg font-semibold">{title}</h2>
      {children}
    </section>
  );
}
