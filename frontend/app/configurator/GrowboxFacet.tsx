"use client";
import ArticleFacet from "./ArticleFacet";

export default function GrowboxFacet() {
  return (
    <ArticleFacet
      category="growbox"
      selectionKey="growbox"
      title="Growbox"
      queryKey={["growboxArticles"]}
    />
  );
}
